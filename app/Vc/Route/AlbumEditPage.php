<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlMenuPage;
use App\Models\Route;
use App\Lib\Icons;
use App\Vc\Lib\TopMenu;
use App\Vc\Lib\TextRouteLink;
use App\Vc\Lib\VLayout;
use App\Vc\Lib\YesNoLink;
use App\Vc\Lib\IconTexLink;
use App\Vc\Lib\IconTextLink;

class AlbumEditPage extends HtmlMenuPage{
    private $route;
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct();
    }
    
    function setup()
    {
        $this->setCurrentTag("routes");
        $this->title=__("Edit album");
        parent::setup();
    }
    function content()
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
            $l_vl=new VLayout();
            $l_vl->addItem(new IconTextLink("images.del", ["id"=>$l_routeImage->id], Icons::DELETE, __("Delete image")));
            if($l_routeImage->id != $l_last->id){
                $l_vl->addItem(new TextRouteLink("images.moveup", ["id_routeImae"=>$l_routeImage->id], __("Move down")));
            }
            if($l_routeImage->position>1){
                $l_vl->addItem(new TextRouteLink("images.movedown",["id_routeImae"=>$l_routeImage->id],__("Move up")));
            }
            $l_vl->addItem(new YesNoLink("images.onsummary",["id_routeImage"=>$l_routeImage->id], __("show on overview page"),$l_routeImage->onsummary) );
            $l_vl->display();
            $this->theme->route_AlbumEdit->imageEditFooter();
        }
    }
}