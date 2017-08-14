<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\TopMenu;
use App\Models\RouteTrace;
use App\Vc\Lib\InfoTable;
use App\Vc\Lib\StaticText;
use App\Lib\Localize;
use App\Vc\Lib\BulletList;
use App\Vc\Lib\TextRouteLink;
use App\Vc\Lib\HtmlMenuPage2;

class ShowPage extends HtmlMenuPage2
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
    
    function setup():void
    {
        $this->setCurrentTag("traces");
        parent::setup();
    }
    
    
    function routeList(RouteTrace $p_routeTrace): void
    {
        $this->top->add(new StaticText(__("Routes using this trace"),"traces_route_title"));
            
        $l_routes = $p_routeTrace->routes;
        if(count($l_routes)==0){
            $this->top->add(new StaticText(__("Nothing found")));            
        } else {
            $l_list=new BulletList();
            foreach($l_routes as $l_route){
                $l_list->add(new TextRouteLink("display.overview",["p_id_route"=>$l_route->id],$l_route->title));
            }
            $this->top->add($l_list);
        }
    }
    
    function setupContent():void
    {     
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("routes.newdetails",["id"=>$this->trace->id], __("Add as route"));
        if (!$this->trace->hasRoutes()) {
            $l_topMenu->addConfirmMenuitem('traces.del', ['id' => $this->trace->id],__("Delete this route trace"), __("Delete this route trace?"));
        }
        $this->top->add($l_topMenu);        
        $l_table=new InfoTable();
        $l_table->addText(__("Uploaded by"),$this->trace->user->name);
        $l_table->addText(__("Location"),$this->trace->getLocationString());
        $l_table->addText(__("Recorded at"),Localize::shortDate($this->trace->startdate));
        $l_table->addText(__("Distance"),Localize::meterToDistance((int)$this->trace->distance));
        $l_table->add(new StaticText(__("Download")));
        $l_table->add(new TraceDownloadLink($this->trace));
        $this->top->add($l_table);  
        $this->top->add(new OpenLayer($this->trace));
		$this->routeList($this->trace);		
    }
}