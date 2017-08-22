<?php
declare(strict_types = 1);
namespace App\Vc;

use App\Vc\Lib\HtmlPage;
use Illuminate\Database\Eloquent\Collection;
use XMLView\Engine\Data\DataStore;;

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
    
    /**
     * Display summary information about some routes
     *
     * @param array $p_routes
     */
    function printRoutesSummary(Collection $p_routes): void
    {
        if (count($p_routes) > 0) {
            
            $this->theme->route_Search->foundHeader();
            
            foreach ($p_routes as $l_route) {
                $this->theme->route_Search->routeSummary($l_route);
            }
            $this->theme->route_Search->foundFooter();
        }
    }
    /**
     * Display the home page, containing a full text search and by a list of locations
     * Contains a search input and search by a list of locations
     *  After selecting a location or submitting a search result a list of 
     */
    function content(?DataStore $p_store=null):void
    {
        $this->theme->route_Search->routeSearch();
        $this->theme->route_Search->searchByLocation($this->tree, $this->locations);
        $this->printRoutesSummary($this->routes);
    }
}