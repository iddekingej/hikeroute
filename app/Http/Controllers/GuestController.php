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
				"routes"=>Route::orderBy("id","asc")->get()
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
		
		$l_gpxParser=new GPXReader();
		$l_gpx=$l_gpxParser->parse($l_route->routefile()->getResults()->gpxdata);		
		$l_data=[
		"id"=>$p_id
		,"id_routefile"=>$l_route->id_routefile
		,"info"=>$l_gpx->getInfo()
		,"title"=>$l_route->title
		,"location"=>$l_route->location
		,"comment"=>$l_route->comment
		,"canEdit"=>Gate::allows("edit-route",$l_route)
		,"creator"=>$l_route->user()->getResults()->name
		,"uploadDate"=>$l_route->created_at
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