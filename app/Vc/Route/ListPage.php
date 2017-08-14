<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\HtmlMenuPage2;

/**
 * Displays a list of routes.
 *
 */
class ListPage extends HtmlMenuPage2
{
    private $routes;
 
    /**
     * Setup page 
     * 
     * @param unknown $p_routes A list of Route objects.
     *                          This routes are displayed on the page
     */
    function __construct($p_routes)
    {
        $this->routes=$p_routes;
        parent::__construct();
    }
    
    function setup():void
    {
        $this->title=__("User route traces");
        $this->setCurrentTag("routes");
        parent::setup();
    }
    
    /**
     * This page consists of a top menu (For the add new route option)
     * And a list of routes

     */
    function setupContent():void
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("routes.new",[], __("Add new route"));
        $this->top->add($l_topMenu);
        $this->top->add(new RouteTable($this->routes));        
    }
}