<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Uploaded hiking route information
 *
 */
class Route extends Model
{
	protected $table="routes";
	protected $fillable = ["id_user","title","comment","id_routefile","location"];
	
	/**
	 * Get the user to which the route belongs to (=has posted)
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function user()
	{
		return $this->belongsTo(User::class,"id_user");
	}
	
	
	function routeFile()
	{
		return $this->hasOne(RouteFile::class,"id","id_routefile");
	}
	
	static function userHasRoutes(User $p_user)
	{
		return self::where("id_user","=",$p_user->id)->limit(1)->get()->isEmpty();
	}
}