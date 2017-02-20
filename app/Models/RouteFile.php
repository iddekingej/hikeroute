<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * RouteFile table contains the content of the GPX file.
 *
 */

class RouteFile extends Model{
	
	/**
	 * Returns the route to which this file belongs
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */	
	function Route()
	{
		return $this->belongsTo(Route::class,"id_routefile");
	}
	protected $table="routefiles";	
	protected $fillable = ["gpxdata"];
}