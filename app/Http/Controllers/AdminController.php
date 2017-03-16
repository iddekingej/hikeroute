<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\UserRight;
use App\Models\Right;

/**
 *  Controller for site administration
 *  Can only be used by administrator users.
 */
class AdminController extends Controller
{
	
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Checks if the user has admin rights
	 */
	private function checkAuthentication()
	{

		if(!\Auth::user()->isAdmin()){
			abort(403);
		}
	}
	
	/**
	 * Displays all users
	 * 
	 * Call view "admin.userlist" with a list for all users
	 */
	
	function listUsers()
	{
		$this->checkAuthentication();		
		return view("admin.userlist",["users"=>\App\Models\User::orderBy("name")->get()]);
	}
	
	private function getRightsArray()
	{
		$l_rights=[];
		foreach(Right::all() as $l_right){
			$l_rights[$l_right->id]=[$l_right,false];
		}
		return $l_rights;
	}
	
	/**
	 * Edit user.
	 * 
	 * Calls "admin.user" view with user id in "$id"
	 * This view contains a user edit form.
	 * 	 
	 * @param int $id User id to edit.
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory view to display
	 */
	
	function editUser(User $p_user)
	{
		$this->checkAuthentication();
		
		$l_rights=$this->getRightsArray();
		$l_userRights=$p_user->userRights();
		foreach ( $l_userRights->getResults() as $l_userRight ) {
			$l_rights[$l_userRight->id_right][1] = true;
		}		
		
		return view("admin.user",
					["id"=>$p_user->id,
					"name"=>$p_user->name,
					"firstname"=>$p_user->firstname,
					"lastname"=>$p_user->lastname,
					"email"=>$p_user->email,
					"title"=>"Edit user",
					"rights"=>$l_rights,
					"cmd"=>"edit"]);
	}
	
	/**
	 * Handles adding a new users.
	 * This method displays the admin.user view.
	 * In this view a empty form is displayed for entering a
	 * new user.
	 * 
	 * @return View  view to display
	 */
	function newUser()
	{
		$this->checkAuthentication();
		$l_rights=$this->getRightsArray();
		return view("admin.user",
					["id"=>"",
					"name"=>"",
					 "firstname"=>"",
					"lastname"=>"",
					 "email"=>"",
					 "title"=>"New user",
					 "cmd"=>"add",
					
					 "rights"=>$l_rights
					]);
	}
	/**
	 * Deletes an user.
	 * The user can't delete their own user record.
	 * 
	 * @param integer $p_id
	 * @return redirect redirects to the user overview
	 */
	
	function deleteUser(User $p_user)
	{
		$this->checkAuthentication();
		if($p_user->id != \Auth::user()->id){		
			$p_user->userRights()->delete();
			$p_user->delete();
		}
		return Redirect::to("/admin/users/");
	}
	
	/**
	 * Save rights belonging to user.
	 * First all existing rights are deleted and then 
	 * the new rights inserted again.
	 * 
	 * @param Request $p_request  Post request form form (contains data to save)
	 * @param \App\User $p_user   User 
	 */
	
	private function saveRights(Request $p_request,User $p_user)
	{
		$p_user->deleteRights();
		foreach(Right::all() as $l_right){
			if($p_request->has("right_".$l_right->id)){
				UserRight::addUserRight($p_user,$l_right);
			}
		}
	}
	
	/**
	 * After submitting a new user, this method
	 * validates the data and inserts the user in the "user" table.
	 * 
	 * @param Request $p_request
	 * @return Redirect 
	 */
	
	function saveUserAdd(Request $p_request)
	{		
		$l_rules=[
			"email"=>["required","email",Rule::unique("users")]
		,	"name"=>["required"]
		,	"firstname"=>["required"]
		,	"lastname"=>["required"]
		,	"password"=>["required"]
		,	"passwordconf"=>["same:password"]
		];		
		
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
			
			return Redirect::to("/admin/users/new")
			       ->withErrors($l_validator)
			       ->withInput($p_request->all());
		}
		
		$l_user=User::create([
				 "name"=>$p_request->input("name")
				,"firstname"=>$p_request->input("firstname")
				,"lastname"=>$p_request->inpurt("lastname")
				,"email"=>$p_request->input("email")
				,"password"=>bcrypt($p_request->input("password"))]);
		$this->saveRights($p_request,$l_user);
		return Redirect::to("/admin/users/");
	}
	
	/**
	 * This method is called after submitting "edit user" form.
	 * The user data is saved in the "User" table
	 *  
	 * @param Request $p_request Data posted from the "edit user" form.
	 * @return unknown
	 */
	function saveUserEdit(Request $p_request)
	{
		$l_id=$p_request->input("id");
		$this->checkInteger($l_id);
		
		$l_rules=[
				"email"=>["required","email",Rule::unique("users")->ignore($l_id)]
				,"name"=>["required"]
			   ,"firstname"=>["required"]
				,"lastname"=>["required"]
		];
		if($p_request->has("resetpassword")){
			$l_rules["password"]=["required"];
			$l_rules["passwordconf"]=["same:password"];
		}
	
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
				
			return Redirect::to("/admin/users/edit/$l_id")
			               ->withErrors($l_validator)
			               ->withInput($p_request->all());
		} 
		$l_user=User::findOrFail($l_id);
		$l_user->name=$p_request->input("name");
		$l_user->firstname=$p_request->input("firstname");
		$l_user->lastname=$p_request->input("lastname");
		$l_user->email=$p_request->input("email");
		if($p_request->has("resetpassword")){
			$l_user->password=bcrypt($p_request->input("password"));
		}
		$l_user->save();
		$this->saveRights($p_request,$l_user);
		return Redirect::to("/admin/users/");
	}
}