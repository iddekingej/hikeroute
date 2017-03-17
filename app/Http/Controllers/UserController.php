<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display user  profile, nothing yet...
	 * 
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	function displayProfile()
	{
		return View("user.profile",["user"=>\Auth::user()]);
	}
	
	function editProfile()
	{
		return View("user.edit",["user"=>\Auth::user()]);
	}
	
	function saveProfile(Request $p_request)
	{
		$l_validator=User::validateRequest($p_request,\Auth::user()->id,false);
		if($l_validator->fails()){
		
			return Redirect::to("/user/profile/edit")
			->withErrors($l_validator)
			->withInput($p_request->all());
		}
		
		$l_user=\Auth::user();
		$l_user->name=$p_request->input("name");
		$l_user->firstname=$p_request->input("firstname");
		$l_user->lastname=$p_request->input("lastname");
		$l_user->email=$p_request->input("email");
		$l_user->save();
		return View("user.profile",["user"=>\Auth::user()]);
	}
}