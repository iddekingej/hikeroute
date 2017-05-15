<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\ImageList;

class OverViewPage extends DisplayPage
{
    function setup()
    {
        $this->currentCode="overview";
        parent::setup();
    }
    
    function setupTopMenu()
    {
        $l_params=["id"=>$this->route->id];
        $this->topMenu->addMenuItem("routes.edit", $l_params, __("Edit route"));
        $this->topMenu->addMenuitem("routes.trace.edit", $l_params,  __("Upload new gpx file"));
        $this->topMenu->addConfirmMenuitem("routes.del",$l_params,__("Delete this route"), __("Delete route?"));
        
    }
    
    function content()
    {
        $l_routeInfo=new RouteInfo($this->route);
        $l_routeInfo->display();
        $l_images=$this->route->summaryImages;
        if(!$l_images->isEmpty()){
            $this->theme->route_Info->albumHeader();
            $l_album=new ImageList($l_images);
            $l_album->display();
            $this->theme->route_Info->albumLink($this->route);
        }
    }
}