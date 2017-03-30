<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $table="locations";
	protected $fillable = ["id_locationtype","id_parent","name"];
	
	function parentLocation()
	{
		return $this->belongsTo(Location::class,"id_parent");
	}
}
