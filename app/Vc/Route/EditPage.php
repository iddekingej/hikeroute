<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\RouteTrace;
use App\Models\Route;
use App\Vc\Trace\OpenLayer;
use Illuminate\Support\ViewErrorBag;
use App\Vc\Lib\HtmlPage2;

/**
 * Page for editing a existing route or adding a new route 
 *
 */

class EditPage extends HtmlPage2
{
    private $route;
    private $routeTrace;
    private $errors;
    
    /**
     * 
     * @param Route $p_route Route to edit or null when adding a new route.      
     * @param RouteTrace $p_routeTrace Null when editing a existing route or a RouteTrace used in a new route
     * @param ViewErrorBag $p_errors Form errors
     */
    function __construct(?Route $p_route,?RouteTrace $p_routeTrace,ViewErrorBag $p_errors)
    {
        $this->route=$p_route;
        $this->routeTrace=$p_routeTrace;
        $this->errors=$p_errors;
        parent::__construct();
    }
    
    /**
     * Set page table
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage2::setup()
     */
    function setup():void
    {
        $this->title=__("Edit route");
        parent::setup();
    }
    /**
     * Setup content:
     *  - A map with the GPS route trace
     *  - A form in which information about the route can be entered
     *  
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage2::setupContent()
     */
    function setupContent():void
    {
        $this->top->add(new OpenLayer($this->routeTrace));
        $this->top->add(new RouteForm($this->route,$this->routeTrace,$this->errors));        
    }
}