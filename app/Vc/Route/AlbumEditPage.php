<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Lib\Icons;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\IconTextLinks;
use App\Vc\Lib\Thumbnail;
use App\Vc\Lib\HtmlMenuPage2;
use App\Vc\Lib\HorizontalSizer;
use App\Vc\Lib\Align;
use App\Vc\Lib\Spacer;

class AlbumEditPage extends HtmlMenuPage2{
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
    function setupContent():void
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));        
        $l_topMenu->addMenuItem("display.album",["id"=>$this->route->id], __("Back to route"));
        $this->top->add($l_topMenu,'100%','0');        
        $l_data=$this->route->routeImages()->orderBy("position")->get() ;
        $l_last=$l_data->last();
        foreach($l_data as $l_routeImage)
        {
            $l_sizer=new HorizontalSizer();
            $this->top->add($l_sizer);
            $l_sizer->add(new Thumbnail($l_routeImage),"0px","0px",Align::RIGHT);
            $l_list=new IconTextLinks();
            $l_sizer->add($l_list,"100%","0px");
            $l_list->addItem(ICONS::DELETE,"images.del", ["id"=>$l_routeImage->id],__("Delete"));
            if($l_routeImage->position>1){
                $l_list->addItem(ICONS::UP,"images.movedown",["id_routeImage"=>$l_routeImage->id],__("Move up"));
            }
            if($l_routeImage->id != $l_last->id){
                $l_list->addItem(ICONS::DOWN,"images.moveup",["id_routeImage"=>$l_routeImage->id],__("Move down"));
            }
            $l_list->addItem("","images.onsummary",["p_id_routeImage"=>$l_routeImage->id,"p_flag"=>$l_routeImage->onsummary?0:1],$l_routeImage->onsummary?__("Remove image from overview page"):__("Add  to overview page"));
            $l_list->addItem(Icons::ROTR, "images.rotr",["p_id_routeImage"=>$l_routeImage->id],__("Rotate right"));
            $l_list->addItem(Icons::ROTL, "images.rotl",["p_id_routeImage"=>$l_routeImage->id],__("Rotate right"));
        }
        $this->top->add(new Spacer(Spacer::VERTICAL),"","100%");
    }
}