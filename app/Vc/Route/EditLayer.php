<?php
declare(strict_types=1);
namespace App\Vc\Route;

use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\DataItemStore;
use XMLView\Base\Base;

class EditLayer extends Base implements  DataLayer
{
    function processData(DataStore $p_parent):DataStore
    {
        $l_route=$p_parent->getValue("route");
        $l_store=new DataItemStore($p_parent,$l_route);
        $l_store->setValue("url", route("routes.save.edit",["id"=>$l_route->id,"id_routetrace"=>$l_route->routeTrace->id]));
        $l_store->setValue("cancelUrl",Route("routes"),[]);
        return $l_store;
    }
}