<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Trace\OpenLayer;
use App\Vc\Lib\TopMenu;

class TracePage extends DisplayPage2
{
    function setup():void
    {
        $this->currentCode="trace";
        parent::setup();
    }
    
    function setupTopMenu():void
    {
        $this->topMenu->addMenuitem("routes.trace.edit", ["id"=>$this->route->id],  __("Upload new gpx file"));
    }
    function setupContent():void
    {
        parent::setupContent();
        $this->top->add(new OpenLayer($this->route->routeTrace),"100%","100%");        
    }
}