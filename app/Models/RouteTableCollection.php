<?php 
declare(strict_types=1);
namespace App\Models;

use App\Lib\TableCollection;
use Illuminate\Database\Eloquent\Collection;

class RouteTableCollection extends TableCollection
{
	static protected $model=Route::class;
	/**
	 * Recalculate summary information of all routes
	 * Called from command line with artisan 
	 */
	static function recalcAllGpx():void
	{
		self::chunk(10,function($p_routes){
			foreach($p_routes as $l_route){
				try{
					$l_route->recalcGpx();
				} catch(\Exception $e){
					echo "Route id=",$l_route->id,'-',$e->getMessage(),"\n";
					echo $e->getTraceAsString(),"\n";
				}
			}
		});
	}
	
	/***
	 * Full text search of all routes
	 * 
	 * @param  string  $p_term
	 * @return Collection
	 */
	
	
	static function search(string $p_term):Collection
	{
		$l_term="%$p_term%";
		return static::where("title","like",$l_term)->orWhere("location","like",$l_term)->orWhere("comment","like",$l_term)->get();
	}
	/**
	 * Get location and number of routes for a location with parent $p_id_parent
	 * 
	 * @param int|null $p_id_parent Get all location with this parent. When null: get root parent
	 * @return array
	 */
	static function numRoutesByLocation($p_id_parent):Array
	{
		if($p_id_parent === null){
			return \DB::select(\DB::raw("select l.id,l.name,count(1) num from routes r join routetraces t on (r.id_routetrace=t.id) join tracelocations tl on(t.id=tl.id_routetrace) join locations l on (tl.id_location=l.id) where l.id_parent is null  group by l.name,l.id order by l.name"));
		} else {
			return \DB::select(\DB::raw("select l.id,l.name,count(1) num from routes r join routetraces t on (r.id_routetrace=t.id) join tracelocations tl on(t.id=tl.id_routetrace) join locations l on (tl.id_location=l.id) where l.id_parent=:id  group by l.name,l.id order by l.name"),["id"=>$p_id_parent]);
		}
	}
	
	
}
?>