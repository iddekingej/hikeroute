<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Trace\OpenLayer;

class TracePage extends DisplayPage
{
    function setup()
    {
        $this->currentCode="trace";
        parent::setup();
    }
    function content()
    {
        
        $l_trace=new OpenLayer($this->route->routeTrace);
        $l_trace->display();
        
    }
}