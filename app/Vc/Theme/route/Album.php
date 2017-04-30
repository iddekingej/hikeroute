<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;
use App\Models\RouteImage;

class Album extends ThemeItem
{
    function thumbnail(RouteImage $p_routeImage)
    {
        echo self::tag("a")->property("href",Route("images.display",["id"=>$p_routeImage->id]))
        ->inner("img")
           ->property("src",Route("images.thumbnail",["id"=>$p_routeImage->id]))
        ->endInner();
    }
}