<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RouteFile extends Model{
	function Route()
	{
		return $this->belongsTo(Route::class,"id_routefile");
	}
	protected $table="routefiles";	
	protected $fillable = ["gpxdata"];
}