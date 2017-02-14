<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Gate;

class GuestController extends Controller
{
	public function start()
	{
		return view("welcome");
	}
	
	function displayRoute($p_id)
	{
		$l_route=\App\Route::findOrFail($p_id);
		$l_gpxParser=new \App\Lib\GPXReader();
		$l_gpx=$l_gpxParser->parse($l_route->gpxdata);		
		$l_data=[
		"id"=>$p_id
		,"info"=>$l_gpx->getInfo()
		,"title"=>$l_route->title
		,"comment"=>$l_route->comment
		,"canEdit"=>Gate::allows("edit-route",$l_route)
		,"creator"=>$l_route->user()->getResults()->email
		,"uploadDate"=>$l_route->created_at
		];
		return View("routes.display",$l_data);
	}
	
	function downloadRoute($p_id)
	{
		$l_route=\App\Route::findOrFail($p_id);
		return $l_route->gpxdata;
	}
}