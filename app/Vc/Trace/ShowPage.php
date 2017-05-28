<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\HtmlMenuPage;
use App\Vc\Lib\TopMenu;
use App\Models\RouteTrace;

class ShowPage extends HtmlMenuPage
{
    private $trace;
    
    function __construct(RouteTrace $p_trace)
    {
        $this->trace=$p_trace;
        parent::__construct();
        $this->extraJs[]="/js/ol.js";
        $this->extraCss[]="/css/ol.js";
        $this->title=__("Route trace");
    }
    
    function setup()
    {
        $this->setCurrentTag("traces");
        parent::setup();
    }
    
    
    function routeList(RouteTrace $p_routeTrace): void
    {
        $l_routes = $p_routeTrace->routes;
        $this->theme->trace_Show->routeListTitle();
        if(count($l_routes)==0){
            $this->theme->trace_Show->routeNothignFound();
        } else {
            $this->theme->trace_Show->routeListHeader();
            foreach ($p_routeTrace->routes as $l_route) {
                $this->theme->trace_Show->routeListItem($l_route->id,$l_route->title);
            }
            $this->theme->trace_Show->routeListFooter();
        }
    }
    
    function content()
    {
        $this->theme->trace_Show->container();
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("routes.newdetails",["id"=>$this->trace->id], __("Add as route"));
        if (!$this->trace->hasRoutes()) {
            $l_topMenu->addConfirmMenuitem('traces.del', ['id' => $this->trace->id],__("Delete this route trace"), __("Delete this route trace?"));
        }
        $l_topMenu->display();
        $this->theme->trace_Show->infoHeader();
        $this->theme->trace_Show->traceInfo($this->trace);
		$this->theme->trace_Show->mapHeader();
		$l_trace=new OpenLayer($this->trace);
 		$l_trace->display();
		$this->theme->trace_Show->mapFooter();
		$this->routeList($this->trace);		
    }
}