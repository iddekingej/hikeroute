<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraceLocation extends Model
{
	protected $table="tracelocations";
	protected $fillable =["id_location","id_routetrace","position"];
	
	function getRouteTrace()
	{
		return self::belongsTo(RouteTrace::class,"id_routetrace")->getResults();	
	}
	
	function getLocation()
	{
		return self::belongsTo(Location::class,"id_location")->getResults();
	}
}