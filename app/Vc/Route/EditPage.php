<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlPage;
use App\Lib\Frm;
use App\Models\RouteTrace;
use App\Models\Route;

class EditPage extends HtmlPage
{
    private $route;
    private $routeTrace;
    private $errors;
    
    function __construct(?Route $p_route,?RouteTrace $p_routeTrace,$p_errors)
    {
        $this->route=$p_route;
        $this->routeTrace=$p_routeTrace;
        $this->errors=$p_errors;
        parent::__construct();
    }
    
    function content()
    {
        $l_data=[
            "id"=>$this->route?$this->route->id:""
         ,  "id_routetrace"=>$this->routeTrace?$this->routeTrace->id:""
        ];
        if($this->route){
            Frm::header(__("Edit trace"),"routes.save.edit", $l_data);
        } else {
            Frm::header(__("New trace"),"routes.save.add", $l_data);
        }
        Frm::text("routeTitle", __("Title"), $this->route?$this->route->title:"", $this->errors);
        Frm::text("routeLocation", __("Location"), $this->route?$this->route->location:"", $this->errors);
        Frm::checkbox("publish",__("Publish"),$this->route?$this->route->publish:"");
        Frm::textarea("comment",__("Description"),$this->route?$this->route->comment:"","40x5",$this->errors);
        Frm::submit(Route("routes"));
        
    }
}