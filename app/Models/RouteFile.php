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
	function route():BelongsTo
	{
		return $this->belongsTo(Route::class,"id","id_routefile");
	}
	

	/**
	 * The user who has uploaded the routefile 
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function user():BelongsTo
	{
		return $this->belongsTo(User::class,"id_user");
	}
}