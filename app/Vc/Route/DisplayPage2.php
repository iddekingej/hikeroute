<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlMenuPage2;
use App\Models\Route;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\StaticText;
use App\Vc\Lib\PageMenu;

abstract class DisplayPage2 extends HtmlMenuPage2{
    protected $route;
    protected $canEdit;
    protected $currentCode;
    protected $topMenu;
    
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct();
        $this->canEdit=$this->route->canEdit(\Auth::user());
    }
    
    
    abstract function setupTopMenu();
    
    function setupContent()
    {
        if($this->canEdit){
            $this->topMenu=new TopMenu();
            $this->setupTopMenu();            
            $this->top->add($this->topMenu,"100%","0px");
        }
        $this->top->add(new StaticText($this->route->title,"traces_route_title"),"100%","0px");        
        $l_pageMenu=new PageMenu();
        $l_pageMenu->setCode($this->currentCode);
        $l_params=["id"=>$this->route->id];
        $l_pageMenu->addItem("overview", Route("display.overview",$l_params), __("Overview"));
        $l_pageMenu->addItem("trace", Route("display.trace",$l_params), __("Route map"));
        if($this->canEdit||$this->route->hasImages()){
            $l_pageMenu->addItem("album",Route("display.album",$l_params),__("Album"));
        }
        $this->top->add($l_pageMenu,"100%","0px");
        
    }
}