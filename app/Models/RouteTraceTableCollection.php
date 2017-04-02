<?php 
namespace App\Models;

use App\Lib\GPXReader;
use App\Lib\AddressService;
use App\Lib\Control;
use App\Lib\TableCollection;

class RouteTraceException extends \Exception
{
	function __construct($p_msg,$p_previous)
	{
		parent::__construct($p_msg,1,$p_previous);
	}
}

class RouteTraceTableCollection extends TableCollection{
	static protected $model=RouteTrace::class;
	
	public static function updateGpxFile(RouteTrace $p_routeTrace,string $p_gpxData):void
	{
		$l_routeFile=$p_routeTrace->routeFile();
		$l_routeFile->gpxdata=$p_gpxData;
		$l_routeFile->save();
		$l_gpxParser=new GPXReader();
		$l_gpxList=$l_gpxParser->parse($p_gpxData);
		if(Control::addressServiceEnabled()){
			$l_locData=AddressService::locationStringFromGPX($l_gpxList->getStart());
			$l_locations=LocationTableCollection::getLocation($l_locData->data);
			if($l_locations !== null){
				$l_location=end($l_locations);				
				$l_id_location=$l_location->id;
			} else {
				$l_id_location=null;
			}
		} else {
			$l_id_location=null;
		}
		
		$p_routeTrace->id_location=$l_id_location;
		$p_routeTrace->setByGPX($l_gpxList);
	}
	
	public static function addGpxFile(string $p_gpxData):?RouteTrace
	{
		$l_gpxParser=new GPXReader();
		$l_gpxList=$l_gpxParser->parse($p_gpxData);
		$l_locData=AddressService::locationStringFromGPX($l_gpxList->getStart());
		if(Control::addressServiceEnabled()){
			$l_locations=LocationTableCollection::getLocation($l_locData->data);
			if($l_locations !== null){
				$l_location=end($l_locations);
				$l_id_location=$l_location->id;
			} else {
				$l_id_location=null;
			}
		} else {
			$l_id_location=null;
			$l_locations=null;
		}
		$l_routeFile=RouteFile::create(["gpxdata"=>$p_gpxData]);
		$l_info=$l_gpxList->getInfo();
		
		$l_trace=RouteTrace::create([
			"id_routefile"=>$l_routeFile->id
		,	"id_location"=>$l_id_location
		,	"startdate"=>$l_gpxList->getStart()->getDatePart()
		,	"minlon"=>$l_info->minLon
		,	"maxlon"=>$l_info->maxLon
		,	"minlat"=>$l_info->minLat
		,	"maxlat"=>$l_info->maxLat
		,	"distance"=>$l_info->distance
		,	"id_user"=>\Auth::user()->id
		]);
		if($l_locations){
			TraceLocationTableCollection::addTraceLocations($l_trace, $l_locations);
		}
		return $l_trace;
	}
	
	/**
	 * Get traces belonging to a location
	 * 
	 * @param int $p_id_location
	 * @return Array
	 */
	static function byLocation($p_id_location):Array
	{
		$l_traces=[];
		foreach(TraceLocationTableCollection::byLocation($p_id_location) as $l_tc){
			$l_traces[]=$l_tc->getRouteTrace();
		}
		return $l_traces;
	}

}

?>