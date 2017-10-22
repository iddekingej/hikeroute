<?php
declare(strict_types=1);
namespace App\Vc\Route;

use XMLView\Engine\Data\DataLayer;
use App\Models\Route;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\DataItemStore;

class RoutePageLayer implements DataLayer
{

    function processData(DataStore $p_parent): DataStore
    {
        $l_route = $p_parent->getValue("route");
        $l_store = new DataItemStore($p_parent, $l_route);
        $this->routeData($l_store,$l_route);
        return $l_store;
    }
    
    protected function routeData(DataStore $p_store,Route $p_route):void
    {
        
    }
    
}