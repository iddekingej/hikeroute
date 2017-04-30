<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlMenuPage;
use App\Models\Route;
use App\Lib\Icons;

class AlbumEditPage extends HtmlMenuPage{
    private $route;
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct();
    }
    
    function content()
    {
        foreach($this->route->routeImages as $l_routeImage)
        {
            $this->theme->route_AlbumEdit->imageEditHeader();
            $this->theme->route_Album->thumbnail($l_routeImage);
            $this->theme->route_AlbumEdit->imageControls();
            $this->theme->imageTextLink(Route("images.del",["id"=>$l_routeImage->id]), Icons::DELETE, __("Delete image"));
            $this->theme->route_AlbumEdit->imageEditFooter();
        }
    }
}