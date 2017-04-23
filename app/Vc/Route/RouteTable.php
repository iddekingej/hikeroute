<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\TableVC;

class RouteTable extends TableVC
{
    function __construct($p_routes)
    {
        parent::__construct($p_routes);
        $this->addConfig([
           "title"=>["type"=>"@link","title"=>__("Title")]
          ,"createdate"=>["type"=>"@text","title"=>__("Create date")]
          ,"startdate"=>["type"=>"@text","title"=>__("Start date")]
          ,"distance"=>["type"=>"@text","title"=>__("Distance")]
          ,"publish"=>["type"=>"@text","title"=>__("Publish")]
        ]);
        $this->title=__("Routes overview");
    }
    
    function getData($p_item)
    {
        $l_trace=$p_item->routeTrace;
        return [
            "title"=>[Route('routes.display',['id'=>$p_item->id]),$p_item->title]
            ,"createdate"=>\App\Lib\Localize::shortDate($p_item->created_at)
            ,"startdate"=>\App\Lib\Localize::shortDate($l_trace->startdate)
            ,"distance"=>\App\Lib\Localize::meterToDistance((int)$l_trace->distance)
            ,"publish"=> $p_item->publish?__("Yes"):""
        ];
    }
}
