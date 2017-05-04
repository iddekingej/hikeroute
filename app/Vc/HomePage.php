<?php
declare(strict_types = 1);
namespace App\Vc;

use App\Vc\Lib\HtmlPage;
use Illuminate\Database\Eloquent\Collection;

class HomePage extends HtmlPage
{
    private $tree;
    private $routes;
    private $locations;
    
    function __construct(Collection $p_tree,$p_locations,$p_routes)
    {
        $this->tree=$p_tree;
        $this->locations=$p_locations;
        $this->routes=$p_routes;
        parent::__construct();
    }
    function content()
    {
        RouteVC::routeSearch();
        RouteVC::searchByLocation($this->tree, $this->locations);
        RouteVC::printRoutesSummary($this->routes);
    }
}