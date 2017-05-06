<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\PageMenu;
use App\Models\Route;
use App\Vc\Lib\HtmlMenuPage;

abstract class DisplayPage extends HtmlMenuPage
{
    protected $route;
    protected $currentCode;
    
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct();
        $this->extraJs[]="/js/ol.js";
        $this->extraCss[]="/css/ol.js";
    }

    function setup()
    {
        $this->setCurrentTag("routes");
        parent::setup();
    }
      
    function preContent()
    {
        parent::preContent();
        $l_pageMenu=new PageMenu();
        $l_pageMenu->setCode($this->currentCode);
        $l_params=["id"=>$this->route->id];
        $l_pageMenu->addItem("overview", Route("display.overview",$l_params), __("Overview"));
        $l_pageMenu->addItem("trace", Route("display.trace",$l_params), __("Route map"));
        $l_pageMenu->addItem("album",Route("display.album",$l_params),__("Album"));
        $l_pageMenu->display();
    }
}