<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Gate;
use App\Models\Route;
use App\Models\RouteFile;
use App\Models\LocationTableCollection;
use App\Models\RouteTableCollection;
use App\Models\RouteTraceTableCollection;
use Illuminate\Http\Request;

class GuestController extends Controller
{
	/**
	 * Displays a list of all routes at front page
	 */
	
	public function start()
	{
		$l_data=[
				"routes"=>Route::getPublished()
			,	"title"=>__("All available routes")
				,	"locations"=>RouteTableCollection::numRoutesByLocation(null)
				,   "tree"=>[]
				,	"pars"=>""
				,	"routes"=>[]
				,	"routeTraces"=>[]
		];
		
		return view("welcome",$l_data);
	}
	
	public function search(Request $p_request)
	{
		$l_search=$p_request->input("search");
		$l_routes=RouteTableCollection::search($l_search);
		$l_data=[
				"routes"=>Route::getPublished()
				,	"title"=>__("All available routes")
				,	"locations"=>RouteTableCollection::numRoutesByLocation(null)
				,   "tree"=>[]
				,	"pars"=>""
				,	"routes"=>[]
				,	"routes"=>$l_routes
		];
		
		return view("welcome",$l_data);
	}
	
	
	public function location($p_id1,$p_id2=null,$p_id3=null,$p_id4=null)
	{
		$l_ids=[];
		$l_args=func_get_args();
		foreach($l_args as $l_id){
			if($l_id===null){
				break;
			}
			$l_ids[]=$l_id;
		}
		$l_id_location=end($l_ids);
		$l_locations=RouteTableCollection::numRoutesByLocation($l_id_location);
		$l_tree=LocationTableCollection::getLocationsByArray($l_ids);
		$l_traces= RouteTraceTableCollection::byLocation($l_id_location);
		$l_routes=[];
		foreach($l_traces as $l_trace){
			$l_routes[]=$l_trace->route()->getResults();
		}
		$l_data=[
				"routes"=>Route::getPublished()
				,	"title"=>__("Searching for routes")
				,	"locations"=>$l_locations				
				,   "tree"=>$l_tree
				,	"pars"=>implode("/",$l_ids)."/"
				,	"routes"=>$l_routes
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