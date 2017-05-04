<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Trace\OpenLayer;
use App\Vc\Lib\TopMenu;

class TracePage extends DisplayPage
{
    function setup()
    {
        $this->currentCode="trace";
        parent::setup();
    }
    function content()
    {
        if($this->route->canEdit(\Auth::user())){
            $l_menu=new TopMenu();
            $l_menu->addMenuitem("routes.trace.edit", ["id"=>$this->route->id],  __("Upload new gpx file"));
            $l_menu->display();
        }
        $l_trace=new OpenLayer($this->route->routeTrace);
        $l_trace->display();
        
    }
}