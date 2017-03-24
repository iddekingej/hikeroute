<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * RouteFile table contains the content of the GPX file.
 *
 */

class RouteFile extends Model{
	protected $table="routefiles";
	protected $fillable = ["gpxdata","id_user"];

	/**
	 * Returns the route to which this file belongs
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */	
	function route()
	{
		return $this->belongsTo(Route::class,"id","id_routefile");
	}
	

	
	/**
	 * Clean all records in "routefile" that doesn't have a record in the route table.
	 * When a new route is added (1) the user uploads a route file 
	 * (2) The user enters  some details over the hiking route
	 * When this process is aborted in step (2) a record in route file 
	 * still exists.
	 */	
	static function cleanGPX()
	{
		static::whereDoesntHave("route")->delete();
	}
	/**
	 * The user who has uploaded the routefile 
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function user()
	{
		return $this->belongsTo(User::class,"id_user");
	}
}