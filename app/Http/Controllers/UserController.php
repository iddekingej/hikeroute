<?php

namespace App\Http\Controllers;

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
		return View("user.profile");
	}
}