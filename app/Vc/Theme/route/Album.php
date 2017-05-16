<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;
use App\Models\RouteImage;

class Album extends ThemeItem
{
    function thumbnail(RouteImage $p_routeImage)
    {
        echo self::tag("img")
           ->property("onclick","makeImagePopup(".json_encode(Route("images.display",["id"=>$p_routeImage->id])).");")
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