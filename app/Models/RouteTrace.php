<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\GPXReader;
use App\Lib\GPXList;
use Illuminate\Database\Eloquent\Collection;

class RouteTrace extends Model
{
	
	protected $table="routetraces";
	protected $fillable =["id_routefile","id_location","distance","startdate"
						   ,"minlat","maxlat","minlon","maxlon"
	                       ,"id_user"
	];
	
	function user()
	{
		return $this->belongsTo(User::class,"id_user");
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
	function route():Route
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
}
