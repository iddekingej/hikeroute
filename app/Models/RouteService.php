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
}
?>