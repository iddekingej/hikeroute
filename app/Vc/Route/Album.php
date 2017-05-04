<?php 
declare(strict_types=1);
namespace App\Vc\Route;



use App\Models\Route;
use App\Models\RouteImage;
use App\Vc\Lib\HtmlComponent;

class Album extends HtmlComponent{
    private $route;
    
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct();
    }
    
    private function image(RouteImage $p_routeImage)
    {
        ?><div class="album_image"><?php
            $this->theme->route_Album->thumbnail($p_routeImage);
        ?></div><?php 
    }
    
    function display()
    {
        foreach($this->route->routeImages()->orderBy("position")->get() as $l_routeImage)
        {
            $this->image($l_routeImage);
        }
    }
}
?>