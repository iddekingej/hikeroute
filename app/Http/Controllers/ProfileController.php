<?php
namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use XMLView\View\ResourceView;
/**
 * This controller is used for handling the profile page.
 *
 */
class ProfileController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display user profile data.
     *
     * @return View
     */
    
    function displayProfile()
    {
        return new ResourceView("profile/profile.xml",[
            "user" => \Auth::user()
        ]);
    }

    /**
     * Display the profile edit form for the current user.
     *
     * @return View
     */
    
    function editProfile()
    {
        return new ResourceView("profile/edit.xml",["user"=>\Auth::user()]);
    }

    /**
     * User selects edit profile (user.edit) and submits form, than
     * this method first validates the request and than saves profile data
     * to current authenticated users.
     * 
     * @param Request $p_request            
     * @return View
     */
    function saveProfile(Request $p_request)
    {
        $l_validator = User::validateRequest($p_request, \Auth::user()->id, false);
        if ($l_validator->fails()) {
            
            return Redirect::Route("user.profileedit")->withErrors($l_validator)->withInput($p_request->all());
        }
        
        $l_user = \Auth::user();
        $l_user->name = $p_request->input("name");
        $l_user->firstname = $p_request->input("firstname");
        $l_user->lastname = $p_request->input("lastname");
        $l_user->email = $p_request->input("email");
        $l_user->save();
        return $this->displayProfile();        
    }

    /**
     * Displays a form for changing the password of the current authenticated user
     *
     * @return View
     */
    function editPassword()
    {
        return new ResourceView("profile/password.xml");
    }

    /**
     * Save password after edit password form is submitted.
     *
     * @param Request $p_request
     *            Submit request of edit password form
     * @return unknown|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    
    function savePassword(Request $p_request)
    {        
        $l_rules = [
            "password" => [
                "required"
            ],
            "passwordconf" => [
                "required",
                "same:password"
            ]
        ];
        
        $l_validator = Validator::make($p_request->all(), $l_rules);
        if ($l_validator->fails()) {
            return Redirect::Route("user.editpassword")->withErrors($l_validator)->withInput($p_request->all());
        }
        
        $l_user = \Auth::user();
        $l_user->password = bcrypt($p_request->input("password"));
        $l_user->save();
        
        return $this->displayProfile();
    }
}