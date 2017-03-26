<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Gate;
use App\Lib\GPXReader;
use App\Models\Route;
use App\Models\RouteFile;

class GuestController extends Controller
{
	/*
	 * Displays a list of all routes at front page
	 */
	
	public function start()
	{
		$l_data=[
				"routes"=>Route::getPublished()
			,	"title"=>__("All available routes")
		];
		
		return view("welcome",$l_data);
	}
	
	/**
	 * Display route:Map and all route data
	 * also display edit controls when user is allowed to
	 * edit the route	 * 
	 * @param integer $p_id 
	 * @return \Illuminate\View\View View to  display 
	 */
	
	function displayRoute($p_id)
	{
		$l_route=Route::findOrFail($p_id);
		if(!$l_route->canCurrentShow()){
			return View("errors.notallowed",["message"=>__("To view this route")]);
		}
		$l_routeTrace=$l_route->routeTrace()->getResults();
		$l_data=[
		"id"=>$p_id
		,"route"=>$l_route
		,"canEdit"=>Gate::allows("edit-route",$l_route)
		,"creator"=>$l_route->user()->getResults()->name
		,"uploadDate"=>$l_route->created_at
		,"route"=>$l_route
		,"routetrace"=>$l_routeTrace
		,"distance"=>round($l_routeTrace->distance)/1000
		];
		return View("routes.display",$l_data);
	}
	
	/**
	 * Download GPX file 
	 * This is used for displaying the route on the map.  The GPX file is download
	 * loaded via a XHR call.
	 * 
	 * @param integer $p_id 
	 * @return unknown
	 */
	
	function downloadRoute($p_id)
	{
		$l_route=RouteFile::findOrFail($p_id);
		return $l_route->gpxdata;
	}
	
	
}