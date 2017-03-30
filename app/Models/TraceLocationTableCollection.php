<?php 
namespace App\Models;

use App\Lib\TableCollection;

class TraceLocationTableCollection extends TableCollection
{
	static protected $model=TraceLocation::class;
	
	/**
	 * Add TraceLocationRecord: Thats the connection between RouteTrace and location
	 * Information
	 * 
	 * @param RouteTrace $p_routeTrace  Route Trace file
	 * @param array $p_locations  Array of Location objects
	 */
	static function addTraceLocations(RouteTrace $p_routeTrace, Array $p_locations)
	{
		foreach($p_locations as $l_position=>$l_location){
			TraceLocation::create(["id_location"=>$l_location->id,"id_routetrace"=>$p_routeTrace->id,"position"=>$l_position]);
		}
	}
	
	static function getByTrace(RouteTrace $p_routeTrace)
	{
		return static::where("id_routetrace","=",$p_routeTrace->id)->get(); 
	}
}

?>