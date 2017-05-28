<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\RouteTrace;
use App\Models\Route;
use App\Vc\Trace\OpenLayer;
use Illuminate\Support\ViewErrorBag;
use App\Vc\Lib\HtmlPage2;



class EditPage extends HtmlPage2
{
    private $route;
    private $routeTrace;
    private $errors;
    
    function __construct(?Route $p_route,?RouteTrace $p_routeTrace,ViewErrorBag $p_errors)
    {
        $this->route=$p_route;
        $this->routeTrace=$p_routeTrace;
        $this->errors=$p_errors;
        $this->extraJs[]="/js/ol.js";
        $this->extraCss[]="/css/ol.js";
        parent::__construct();
    }
    
    function setup()
    {
        $this->title=__("Edit route");
        parent::setup();
    }
    
    function setupContent()
    {
        $this->top->add(new OpenLayer($this->routeTrace));
        $this->top->add(new RouteForm($this->route,$this->routeTrace,$this->errors));        
    }
}