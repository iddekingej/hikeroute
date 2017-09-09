<?php
declare(strict_types=1);
namespace App\Vc\Route;

use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\DataItemStore;
use XMLView\Base\Base;
use XMLView\Engine\Data\MapData;

class EditLayer extends Base implements  DataLayer
{
    function processData(DataStore $p_parent):DataStore
    {
        $l_route=$p_parent->getValue("route");
        if($l_route){
            $l_store=new DataItemStore($p_parent,$l_route);
            $l_store->setValue("url","display.overview");
            echo "xxxxxx",$l_route->id," ",$l_route->title,"*****";
        } else {
            $l_routeTrace=$p_parent->getValue("routeTrace");
            $l_store=new MapData($p_parent,["url"=>"routes.save.add","id"=>"","title"=>"","location"=>"","comment"=>"","publish"=>false,"id_routetrace"=>$l_routeTrace->id]);
            
        }
        return $l_store;
    }
}