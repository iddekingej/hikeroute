<?php
declare(strict_types=1);
namespace App\Vc\Trace;


use App\Lib\Localize;
use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\MapData;

class ShowDataLayer implements DataLayer{
    function processData(?DataStore $p_parent):DataStore
    {
        $l_trace=$p_parent->getValue("trace");
        $l_map=new MapData($p_parent,
            ["uploadedBy"=>$l_trace->user->name
            ,"location"=>$l_trace->getLocationString()
            ,"recordedAt"=>Localize::shortDate($l_trace->startdate)
            ,"distance"=>Localize::meterToDistance((int)$l_trace->distance)
            ]);
        $l_list=[];
        
        foreach($l_trace->routes as $l_route){
            $l_list[]=new MapData($l_map,["title"=>$l_route->title]);
        }
        $l_map->setValue("usedInRoutes",$l_list);
        return $l_map;
    }
}   