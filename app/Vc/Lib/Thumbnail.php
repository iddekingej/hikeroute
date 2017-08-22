<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Models\RouteImage;
use XMLView\Engine\Data\DataStore;;

class Thumbnail extends HtmlComponent
{
    private $routeImage;
    
    function __construct(RouteImage $p_routeImage)
    {
        $this->routeImage=$p_routeImage;
        parent::__construct();
    }
    
    function display(?DataStore $p_store=null)
    {
        $this->theme->route_Album->thumbnail($this->routeImage);
    }
}

?>