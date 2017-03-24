<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\GPXReader;

class RouteException extends \Exception
{
	function __construct($p_message,$p_previous=null)
	{
		return __construct($p_message,-1,$p_previous);
	}
}

/**
 * Uploaded hiking route information
 *
 */
class Route extends Model
{
	protected $table="routes";
	protected $fillable = ["id_user","title","comment",
			                "id_routefile","location","minlon","maxlon"
							,"minlat","maxlat","publish","distance"
							,"id_location"
	];
	
	function location()
	{
		return $this->belongsTo(Location::class,"id_location");
	}
	
	/**
	 * Get the user to which the route belongs to (=has posted)
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function user()
	{
		return $this->belongsTo(User::class,"id_user");
	}
	
	/**
	 * Contents of the route file 
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	function routeFile()
	{
		return $this->hasOne(RouteFile::class,"id","id_routefile");
	}
	
	/**
	 * Checks if an user has a route uploaded
	 * 
	 * @param User $p_user The use to check of.
	 * @return boolean    true - user
	 */
	
	static function userHasRoutes(User $p_user)
	{
		return self::where("id_user","=",$p_user->id)->limit(1)->get()->isEmpty();
	}
	
	private function recalcGpxByFile($p_content){
		$l_gpxParser=new GPXReader();
		$l_gpxList=$l_gpxParser->parse($p_content);
		$l_gpxInfo=$l_gpxList->getInfo();
		$this->minlon=$l_gpxInfo->minLon;
		$this->maxlon=$l_gpxInfo->maxLon;
		$this->minlat=$l_gpxInfo->minLat;
		$this->maxlat=$l_gpxInfo->maxLat;
		$this->distance=$l_gpxInfo->distance;
		$this->save();		
	}
	
	private function recalcGpx(){
		$this->recalcGpxByFile($this->routeFile()->getResults()->gpxdata);
	}

	function saveRouteFile($p_file)
	{
		$l_content=file_get_contents($p_file);
		if($l_content===false){
			throw new RouteException(__("Uploading gpx file failed"));
		}
		$l_routeFile=$this->routeFile()->getResults();
		$this->recalcGpxByFile($l_content);
		$l_routeFile->gpxdata=$l_content;
		$l_routeFile->save();
		
	}
	
	static function recalcAllGpx()
	{
		self::chunk(10,function($p_routes){
			foreach($p_routes as $l_route){
				try{
					$l_route->recalcGpx();
				} catch(\Exception $e){
					echo "Route id=",$l_route->id,'-',$e->getMessage(),"\n";
				}
			}
		});
	}
	
	static function getPublished()
	{
		return self::where("publish",1)->orderBy("id","asc")->get();
	}
	
}