<?php 
declare(strict_types=1);
namespace App\Vc\Route;


use App\Vc\Lib\ViewComponentBase;
use App\Models\Route;
use App\Models\RouteImage;

class Album extends ViewComponentBase{
    private $route;
    
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
    }
    
    private function image(RouteImage $p_routeImage)
    {
        ?><div class="album_image"><?php
        echo self::tag("a")->property("href",Route("images.display",["id"=>$p_routeImage->id])) 
             ->inner("img")->property("src",Route("images.thumbnail",["id"=>$p_routeImage->id]))
             ->endInner();
        ?></div><?php 
    }
    
    function display()
    {
        foreach($this->route->routeImages()->get() as $l_routeImage)
        {
            $this->image($l_routeImage);
        }
    }
}
?>