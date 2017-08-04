<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlComponent;
use App\Models\Route;
/**
 * Display overview data about a route 
 *
 */
class RouteInfo extends HtmlComponent
{
    private $route;
    
    function __construct(Route $p_route){
        $this->route=$p_route;
        parent::__construct();
    }
    

    function display():void
    {
        $this->theme->route_Info->routeInfo($this->route);
    }
}