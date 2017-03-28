<?php 
namespace App\Models;
use App\Lib\TableService;

class RouteService extends TableService
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
}
?>