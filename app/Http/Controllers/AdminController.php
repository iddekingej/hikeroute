<?php 
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
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
	 * Displayes all users
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
	
	function editUser($id)
	{
		$this->checkAuthentication();
		$l_user=User::findOrFail($id);
		$l_rights=$this->getRightsArray();
		$l_userRights=$l_user->userRights();
		foreach ( $l_userRights->getResults() as $l_userRight ) {
			$l_rights[$l_userRight->id_right][1] = true;
		}		
		return view("admin.user",
					["id"=>$l_user->id,
					"name"=>$l_user->name,
					"email"=>$l_user->email,
					"title"=>"Edit user",
					"rights"=>$l_rights]);
	}
	
	/**
	 * handles add users.
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
					 "email"=>"",
					"title"=>"New user",
					"rights"=>$l_rights
					]);
	}
	/**
	 * Delete an user.
	 * The user can't it's own user record.
	 * 
	 * @param integer $p_id
	 * @return redirect redirects to the user overview
	 */
	function deleteUser($p_id)
	{
		$this->checkAuthentication();
		if($p_id != \Auth::user()->id){
			$l_user=User::findOrFail($p_id);
			$l_user->delete();
		}
		return Redirect::to("/admin/users/$p_id");
	}
	
	/**
	 * Save rights belonging to users.
	 * First all rights are deleted and then inserted again.
	 * 
	 * @param Request $p_request  Post request form form (contains data to save)
	 * @param \App\User $p_user   User 
	 */
	
	function saveRights(Request $p_request,User $p_user)
	{
		$p_user->deleteRights();
		foreach(Right::all() as $l_right){
			if($p_request->has("right_".$l_right->id)){
				UserRight::addUserRight($p_user,$l_right);
			}
		}
	}
	
	/**
	 * Validates ,save of insert data in the table.
	 * 
	 * @param Request $p_request
	 * @return Redirect 
	 */
	function saveUser(Request $p_request)
	{
		$l_id=$p_request->input("id");
		
		$l_rules=[
			"email"=>["required","email",Rule::unique("users")->ignore($l_id)]
		,	"name"=>["required"]
		];
		if($l_id==""||$p_request->has("resetpassword")){
			$l_rules["password"]=["required"];
		}
		
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
			
			return Redirect::to("/admin/users/".(($l_id=="")?"new":"edit/$l_id"))
			       ->withErrors($l_validator)->withInput($p_request->all());
		} else if($l_id != ""){
			$l_user=User::findOrFail($l_id);				
			$l_user->name=$p_request->input("name");
			$l_user->email=$p_request->input("email");
			if($p_request->has("resetpassword")){
				$l_user->password=bcrypt($p_request->input("password"));
			}
			$l_user->save();
		} else {
			$l_user=User::create(["name"=>$p_request->input("name"),"email"=>$p_request->input("email"),"password"=>bcrypt($p_request->input("password"))]);
			
		}
		$this->saveRights($p_request,$l_user);
		return Redirect::to("/admin/users/");
	}
}