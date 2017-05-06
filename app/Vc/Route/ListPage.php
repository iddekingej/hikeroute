<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\HtmlMenuPage;

class ListPage extends HtmlMenuPage
{
    private $routes;
    
    function __construct($p_routes)
    {
        $this->routes=$p_routes;
        parent::__construct();
    }
    
    function setup()
    {
        $this->title=__("User route traces");
        $this->setCurrentTag("routes");
        parent::setup();
    }
    
    function content()
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("routes.new",[], __("Add new route"));
        $l_topMenu->display();
        $l_tab=new RouteTable($this->routes);
        $l_tab->display();
    }
}