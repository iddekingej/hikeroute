<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\DynamicValue;
use XMLView\Widgets\Base\Widget;
/**
 * Display overview data about a route 
 *
 */
class XMLRouteInfo extends Widget
{
    private $route;
    
    /**
     * Set the route for which the info must be displayed.
     * 
     * @param DynamicValue $p_route The route wrapped in a DynamicValue object
     */
    function setRoute(DynamicValue $p_route):void
    {
        $this->route=$p_route;     
    }
    /**
     * Get the route for which the info must be displayed
     * @return DynamicValue|NULL A Route object wrapped in a DyanmicValue
     */
    
    function getRoute():?DynamicValue
    {
        return $this->route;
    }
    
    /**
     * Display The route info
     * @param DataStore p_store Store must a "route" parameter of class Route 
     */
     function displayContent(?DataStore $p_store=null):void
    {
        $l_route=$this->getAttValue("route",$p_store,Route::class,true);
        $this->theme->app_route_Info->routeInfo($l_route);
    }
}