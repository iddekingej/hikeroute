<?php
declare(strict_types = 1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\UserRight;
use App\Models\Right;
use App\Models\RightTableCollection;
use XMLView\View\ResourceView;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

/**
 * Controller for site administration
 * Can only be used by users with administrator rights.
 */

class AdminController extends Controller
{
/**
 * Setup authentication middleware.
 * User must be logged in and must have administration rights
 */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware("admin");        
    }

    /**
     * Displays all users
     *
     * Call view "admin.userlist" which contains a list with all users
     */
    
    function listUsers()
    {
        return new ResourceView("admin/AllUsers.xml");
    }

    /**
     * Edit user.
     *
     * Calls "admin.user" view with user id in "$id"
     * This view contains a user edit form.
     *
     * @param int $id
     *            User id to edit.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory view to display
     */
    
    function editUser($p_id_user)
    {
 
        $this->checkInteger($p_id_user);
        $l_user = User::findOrFail($p_id_user);
        return new ResourceView("admin/UserAdmin.xml",["user"=>$l_user]);            
    }

    /**
     * Handles adding a new users.
     * This method displays the admin.user view.
     * In this view a form is displayed for entering a new user
     *
     * @return View view to display
     */
    
    function newUser()
    {        
        return new ResourceView("admin/UserAdmin.xml",["user"=>null]);
        
    }

    /**
     * Deletes an user.
     * A user can't delete their own user record.
     *
     * @param User  $p_user  DThis user is going to be deleted          
     * @return redirect redirects to the user overview
     */
    
    function deleteUser(User $p_user)
    {

        if ($p_user->id != \Auth::user()->id) {
            $p_user->deleteDepended();
        }
        return Redirect::route("admin.users");
    }

    /**
     * Save rights belonging to user.
     * First all existing rights are deleted and 
     * the new rights are inserted again.
     *
     * @param Request $p_request
     *            Post request from form (contains data to save)
     * @param \App\User $p_user
     *            Update the rights of this user
     */
    
    private function saveRights(Request $p_request, User $p_user)
    {
        $p_user->deleteRights();
        foreach (Right::all() as $l_right) {
            if ($p_request->has("right_" . $l_right->id)) {
                UserRight::addUserRight($p_user, $l_right);
            }
        }
    }

    /**
     * After submitting a new user, this method
     * validates the data and inserts the user in the "user" table.
     *
     * @param Request $p_request  Post request from the admin.user form.
     * @return Redirect           Redirect to the users overview
     */
    
    function saveUserAdd(Request $p_request)
    {
        $l_validator = User::validateRequest($p_request, - 1, true);
        
        if ($l_validator->fails()) {
            
            return Redirect::Route("admin.users.new")->withErrors($l_validator)->withInput($p_request->all());
        }
        
        $l_user = User::create([
            "name" => $p_request->input("name"),
            "firstname" => $p_request->input("firstname"),
            "lastname" => $p_request->input("lastname"),
            "email" => $p_request->input("email"),
            "enabled" => $p_request->input("enabled") ? 1 : 0,
            "password" => bcrypt($p_request->input("password"))            
        ]);
        $this->saveRights($p_request, $l_user);
        return Redirect::Route("admin.users");
    }

    /**
     * This method is called after submitting "edit user" form.
     * The user data is saved in the "User" table
     *
     * @param Request $p_request
     *            Data posted from the "edit user" form.
     * @Param User  $p_user
     *            User to edit.
     * @return Response
     */
    
    function saveUserEdit(Request $p_request,User $p_user)
    {
        $l_validator = User::validateRequest($p_request, $p_user->id, $p_request->has("resetpassword"));
        if ($l_validator->fails()) {      
            return Redirect::Route("admin.users.edit",["p_id_user"=>$p_user->id])->withErrors($l_validator)->withInput($p_request->all());
        }
        
        $p_user->name = $p_request->input("name");
        $p_user->firstname = $p_request->input("firstname");
        $p_user->lastname = $p_request->input("lastname");
        $p_user->email = $p_request->input("email");
        $p_user->enabled = $p_request->input("enabled") ? 1 : 0;
        if ($p_request->has("resetpassword")) {
            $p_user->password = bcrypt($p_request->input("password"));
        }
        DB::transaction(
               function() use($p_user,$p_request){
                    $p_user->save();
                    $this->saveRights($p_request, $p_user);
                }
        );
        return Redirect::Route("admin.users");
    }
}