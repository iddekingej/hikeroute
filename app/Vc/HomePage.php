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
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::content()
     */
    function content():void
    {
        $this->theme->route_Search->routeSearch();
        $this->theme->route_Search->searchByLocation($this->tree, $this->locations);
        $this->printRoutesSummary($this->routes);
    }
}