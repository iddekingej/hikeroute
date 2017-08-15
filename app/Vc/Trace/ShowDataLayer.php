<?php
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\Engine\Data\DataLayer;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\MapData;

class ShowDataLayer implements DataLayer{
    function processData(?DataStore $p_parent):DataStore
    {
        $l_map=new MapData($p_parent);
        $l_list=[];
        $l_trace=$p_parent->getValue("trace");
        foreach($l_trace->routes as $l_route){
            $l_list[]=new MapData($l_map,["title"=>$l_route->title]);
        }
        $l_map->setValue("usedInRoutes",$l_list);
        return $l_map;
    }
}   