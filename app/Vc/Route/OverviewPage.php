<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Lib\TopMenu;

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
            $l_topMenu->addMenuItem("images.add", $l_params, __("Add image"));
            $l_topMenu->addMenuitem("routes.trace.edit", $l_params,  __("Upload new gpx file"));
            $l_topMenu->addConfirmMenuitem("routes.del",$l_params,__("Delete this route"), __("Delete route?"));
            $l_topMenu->display();
        }
        $l_routeInfo=new RouteInfo($this->route);
        $l_routeInfo->display();
    }
}