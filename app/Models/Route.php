<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\GPXReader;

/**
 * Uploaded hiking route information
 *
 */
class Route extends Model
{
	protected $table="routes";
	protected $fillable = ["id_user","title","comment",
			                "id_routefile","location","minlon","maxlon"
							,"minlat","maxlat","publish"
	];
	
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
	
	private static function recalcSingleGpx(Route $p_route){
		$l_gpxParser=new GPXReader();
		$p_gpxList=$l_gpxParser->parse($p_route->routeFile()->getResults()->gpxdata);
		$l_gpxInfo=$p_gpxList->getInfo();
		$p_route->minlon=$l_gpxInfo->minLon;
		$p_route->maxlon=$l_gpxInfo->maxLon;
		$p_route->minlat=$l_gpxInfo->minLat;
		$p_route->maxlat=$l_gpxInfo->maxLat;
		$p_route->save();
	}
	
	static function recalcAllGpx()
	{
		self::chunk(10,function($p_routes){
			foreach($p_routes as $l_route){
				self::recalcSingleGpx($l_route);
			}
		});
	}
	
	static function getPublished()
	{
		return self::where("publish",1)->orderBy("id","asc")->get();
	}
	
}