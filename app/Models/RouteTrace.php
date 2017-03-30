<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\GPXReader;
use App\Lib\GPXList;

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
	
	function recalcGpx(){
		$l_content=$this->routeFile()->getResults()->gpxdata;
		$l_gpxParser=new GPXReader();
		$l_gpxList=$l_gpxParser->parse($l_content);
		$this->setByGPX($l_gpxList);
	}
	

	function setByGPX(GPXList $p_gpxList)
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
	function route()
	{
		return $this->hasOne(Route::class,"id_routetrace");
	}
	
	/**
	 * Contents of the route file
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	function routeFile()
	{
		return $this->belongsTo(RouteFile::class,"id_routefile");
	}
	
	/**
	 * Get location information.
	 * @return unknown
	 */
	function location()
	{
		return $this->belongsTo(Location::class,"id_location");
	}
	
	function getLocations()
	{
		return TraceLocationTableCollection::getByTrace($this);
	}
}
