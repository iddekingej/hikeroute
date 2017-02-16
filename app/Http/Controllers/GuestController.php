<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Gate;

class GuestController extends Controller
{
	public function start()
	{
		return view("welcome");
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
		$l_route=\App\Model\Route::findOrFail($p_id);
		
		$l_gpxParser=new \App\Lib\GPXReader();
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
	 * 
	 * @param integer $p_id 
	 * @return unknown
	 */
	
	function downloadRoute($p_id)
	{
		$l_route=\App\Model\RouteFile::findOrFail($p_id);
		return $l_route->gpxdata;
	}
}