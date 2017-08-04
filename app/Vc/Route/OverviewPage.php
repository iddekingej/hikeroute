<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\ImageList;
use App\Vc\Lib\TextRouteLink;
use App\Vc\Lib\StaticText;
use App\Vc\Lib\Spacer;

/**
 * This page displays overview information about a route
 * 
 */
class OverViewPage extends DisplayPage
{
    function setup():void
    {
        $this->currentCode="overview";
        parent::setup();
    }
       
    /**
     * 
     * {@inheritDoc}
     * @see \App\Vc\Route\DisplayPage::setupTopMenu()
     */
    function setupTopMenu():void
    {
        $l_params=["id"=>$this->route->id];
        $this->topMenu->addMenuItem("routes.edit", $l_params, __("Edit route"));
        $this->topMenu->addMenuitem("routes.trace.edit", $l_params,  __("Upload new gpx file"));
        $this->topMenu->addConfirmMenuitem("routes.del",$l_params,__("Delete this route"), __("Delete route?"));
        
    }
    
    /**
     * Setup contents of the page:
     * - Summary information
     * - A list of images that have "display of summary page " set
     * 
     */
    function setupContent():void
    {
        parent::setupContent();
        
        $this->top->add(new RouteInfo($this->route),"100%","0px");        
        $l_images=$this->route->summaryImages;
        if(!$l_images->isEmpty()){
            $this->top->add(new StaticText(__("Album"),"routeall_sectionTitle"),"100%","0px");            
            $this->top->add(new ImageList($l_images),"100%","0px");
            $this->top->add(new TextRouteLink("display.album",["id"=>$this->route->id],__("Complete album")),"100%","0px");
        }
        $this->top->add(new Spacer(Spacer::VERTICAL));
        
    }
}