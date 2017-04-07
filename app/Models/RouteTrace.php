<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\GPXReader;
use App\Lib\GPXList;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Array_;

class RouteTrace extends Model
{
	protected $locationsCached;
	protected $table="routetraces";
	protected $fillable =["id_routefile","id_location","distance","startdate"
						   ,"minlat","maxlat","minlon","maxlon"
	                       ,"id_user"
	];
	protected $dates=["startdate"];
	
	function user()
	{
		return $this->belongsTo(User::class,"id_user")->getResults();
	}
	/**
	 * Recalculate summary infornation about GPX trace files
	 */
	function recalcGpx():void
	{
		$l_content=$this->routeFile()->getResults()->gpxdata;
		$l_gpxParser=new GPXReader();
		$l_gpxList=$l_gpxParser->parse($l_content);
		$this->setByGPX($l_gpxList);
	}
	
	/**
	 * Set gpx trace summary information by a  GPXList object.
	 * 
	 * @param GPXList $p_gpxList
	 */

	function setByGPX(GPXList $p_gpxList):void
	{
		$l_gpxInfo=$p_gpxList->getInfo();
		$this->minlon=$l_gpxInfo->minLon;
		$this->maxlon=$l_gpxInfo->maxLon;
		$this->minlat=$l_gpxInfo->minLat;
		$this->maxlat=$l_gpxInfo->maxLat;
		$this->distance=$l_gpxInfo->distance;
		$this->startdate=$p_gpxList->getStart()->getDatePart();
		$this->save();
	}
	
	/**
	 * Get related route
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	function route():?Route
	{
		return $this->hasOne(Route::class,"id_routetrace")->getResults();
	}
	
	/**
	 * Contents of the route file
	 *
	 * @return RouteFile
	 */
	function routeFile():RouteFile
	{
		return $this->belongsTo(RouteFile::class,"id_routefile")->getResults();
	}
	
	/**
	 * Get description of location of the start point of a GPX route trace
	 * 
	 * @return string
	 */
	function getLocationString():string
	{
		$l_return ="";
		foreach($this->getLocations() as $l_location){
			$l_return .= "/".$l_location->getLocation()->name;
		}
		return $l_return;
	}
	
	function getLocationsIndexed():Array
	{
		return TraceLocationTableCollection::getByTraceTypeIndexed($this);
	}
	
	/**
	 * Get cached location info belonging to route traces.
	 * Return is a associative array. Index is the location type and value is the location description
	 * @return array
	 */
	
	function getLocationsIndexCached():Array
	{
		if($this->locationsCached===null){
			$this->locationsCached=$this->getLocationsIndexed();
		}
		return $this->locationsCached;
	}
	
	/**
	 * Get Location object belonging to the route trace by cached data
	 *
	 * @param $p_type Get location  name by locationtype
	 * @return Collection
	 */
	
	function getLocationByTypeCached($p_type):string
	{
		$l_cached=$this->getLocationsIndexCached();
		if(isset($l_cached[$p_type])){
			return $l_cached[$p_type]->name;	
		}
		return "";
	}
	/**
	 * Get Location object belonging to the route trace
	 * 
	 * @return Collection
	 */
	function getLocations():Collection
	{
		return TraceLocationTableCollection::getByTrace($this);
	}
	/**
	 * Delete a RouteTrace record and also all depended data
	 */
	function deleteDepend():void
	{
		TraceLocationTableCollection::deleteByTrace($this);
		$this->delete();
	}
	
	function canViewTrace(User $p_user)
	{
		return ($this->id_user==$p_user->id) || $p_user->getIsAdmin();
	}
}
