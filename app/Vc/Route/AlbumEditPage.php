<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlMenuPage;
use App\Models\Route;
use App\Lib\Icons;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\IconTextLinks;


class AlbumEditPage extends HtmlMenuPage{
    private $route;
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct();
    }
    
    function setup():void
    {
        $this->setCurrentTag("routes");
        $this->title=__("Edit album");
        parent::setup();
    }
    function content():void
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));        
        $l_topMenu->addMenuItem("display.album",["id"=>$this->route->id], __("Back to route"));        
        $l_topMenu->display();
        $l_data=$this->route->routeImages()->orderBy("position")->get() ;
        $l_last=$l_data->last();
        foreach($l_data as $l_routeImage)
        {
            $this->theme->route_AlbumEdit->imageEditHeader();
            $this->theme->route_Album->thumbnail($l_routeImage);
            $this->theme->route_AlbumEdit->imageControls();
            $l_list=new IconTextLinks();
            $l_list->addItem(ICONS::DELETE,"images.del", ["id"=>$l_routeImage->id],__("Delete"));
            if($l_routeImage->position>1){
                $l_list->addItem(ICONS::UP,"images.movedown",["id_routeImage"=>$l_routeImage->id],__("Move up"));
            }
            if($l_routeImage->id != $l_last->id){
                $l_list->addItem(ICONS::DOWN,"images.moveup",["id_routeImage"=>$l_routeImage->id],__("Move down"));
            }
            $l_list->addItem("","images.onsummary",["p_id_routeImage"=>$l_routeImage->id,"p_flag"=>$l_routeImage->onsummary?0:1],$l_routeImage->onsummary?__("Remove image from overview page"):__("Add  to overview page"));
            $l_list->display();
            $this->theme->route_AlbumEdit->imageEditFooter();
        }
    }
}