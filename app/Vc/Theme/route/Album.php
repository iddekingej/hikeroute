<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;
use App\Models\RouteImage;

class Album extends ThemeItem
{
    function thumbnail(RouteImage $p_routeImage)
    {
        $l_params=[
            Route("images.display",["id"=>$p_routeImage->id])
        ,   $p_routeImage->num_views
        ];
        $l_call=$this->makeJsCall("makeImagePopup",$l_params);
        echo self::tag("img")
           ->property("onclick","$l_call;")
           ->property("src",Route("images.thumbnail",["id"=>$p_routeImage->id]));
        
    }
    
    function albumImageHeader()
    {
        ?><div class="album_image"><?php        
    }
    
    function albumImageFooter()
    {
        ?></div><?php
    }
}