<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
