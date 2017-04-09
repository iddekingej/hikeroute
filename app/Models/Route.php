<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteException extends \Exception
{
	function __construct($p_message,$p_previous=null)
	{
		return __construct($p_message,-1,$p_previous);
	}
}


class Route extends Model
{
	protected $table="routes";
	protected $fillable = ["id_user","title","comment",
			                "location","publish","distance"
							,"id_routetrace"
	];
	
	/**
	 * Get the user to which the route belongs to (=has posted)
	 * 
	 * @return User
	 */
	function user():User
	{
		return $this->belongsTo(User::class,"id_user")->getResults();
	}
	
	/**
	 * Contents of the route file 
	 * 
	 * @return RouteTrace
	 */
	function routeTrace():RouteTrace
	{
		return $this->belongsTo(RouteTrace::class,"id_routetrace");
	}
	
	
	/**
	 * Checks if an user has a route uploaded
	 * 
	 * @param User $p_user The use to check of.
	 * @return boolean    true - user
	 */
	
	static function userHasRoutes(User $p_user):bool
	{
		return self::where("id_user","=",$p_user->id)->limit(1)->get()->isEmpty();
	}
	/**
	 * Recalc data from gpx file,like min,max lat/lon and distance 
	 */
	function recalcGPX():void
	{

		$l_routeTrace=$this->routeTrace();		
		if($l_routeTrace){
			$l_routeTrace->recalcGPX();
		}
	}
	
	static function getPublished()
	{
		return self::where("publish",1)->orderBy("id","asc")->get();
	}
	
	/**
	 * Delete route and all depended data
	 * (RouteTrace and routeFile)
	 */
	function deleteDepended():void
	{
			$this->delete();			
	}
	/**
	 * Has the current enough rights to display route
	 * 
	 * @return bool true Current user has display rights to route 
	 *              false Current user has can't view to route
	 *  
	 */
	function canCurrentShow():bool
	{
		if($this->publish==1){
			return true;
		}
		if(\Auth::check()){
			return $this->canShow(\Auth::user());
		}
		return false;
	}
	
	/**
	 * Checks if user can view route
	 * 
	 * @param \App\Models\User $p_user
	 * @return bool
	 */
	
	function canShow(\App\Models\User $p_user):bool
	{
		if($p_user->isAdmin()){
			return true;
		}
		if($this->id_user==$p_user->id){
			return true;
		}
		return ($this->publish);
	}
	
		
}