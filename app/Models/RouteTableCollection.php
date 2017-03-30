<?php 
namespace App\Models;

use App\Lib\TableCollection;

class RouteTableCollection extends TableCollection
{
	static protected $model=Route::class;
	
	static function recalcAllGpx()
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
	
	static function search($p_term)
	{
		$l_term="%$p_term%";
		return static::where("title","like",$l_term)->orWhere("location","like",$l_term)->orWhere("comment","like",$l_term)->get();
	}
	
	static function numRoutesByLocation($p_id_parent)
	{
		if($p_id_parent === null){
			return \DB::select(\DB::raw("select l.id,l.name,count(1) num from routes r join routetraces t on (r.id_routetrace=t.id) join tracelocations tl on(t.id=tl.id_routetrace) join locations l on (tl.id_location=l.id) where l.id_parent is null  group by l.name,l.id order by l.name"));
		} else {
			return \DB::select(\DB::raw("select l.id,l.name,count(1) num from routes r join routetraces t on (r.id_routetrace=t.id) join tracelocations tl on(t.id=tl.id_routetrace) join locations l on (tl.id_location=l.id) where l.id_parent=:id  group by l.name,l.id order by l.name"),["id"=>$p_id_parent]);
		}
	}
	
}
?>