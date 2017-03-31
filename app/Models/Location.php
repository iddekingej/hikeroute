<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $table="locations";
	protected $fillable = ["id_locationtype","id_parent","name"];
	
	/**
	 * Get the parent location  (e.g. city=>state is parent location)
	 * @return Location
	 */
	
	function parentLocation():Location
	{
		return $this->belongsTo(Location::class,"id_parent")->getResults();
	}
}
