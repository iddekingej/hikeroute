<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Models\RouteImage;

class Thumbnail extends HtmlComponent
{
    private $routeImage;
    
    function __construct(RouteImage $p_routeImage)
    {
        $this->routeImage=$p_routeImage;
        parent::__construct();
    }
    
    function display()
    {
        $this->theme->route_Album->thumbnail($this->routeImage);
    }
}

?>