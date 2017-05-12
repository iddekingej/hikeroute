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
    
    
    function content()
    {
        if($this->route->canEdit(\Auth::user())){
            $l_topMenu=new TopMenu();
            $l_params=["id"=>$this->route->id];
            $l_topMenu->addMenuItem("routes.edit", $l_params, __("Edit route"));
            $l_topMenu->addMenuitem("routes.trace.edit", $l_params,  __("Upload new gpx file"));
            $l_topMenu->addConfirmMenuitem("routes.del",$l_params,__("Delete this route"), __("Delete route?"));
            $l_topMenu->display();           
        }
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