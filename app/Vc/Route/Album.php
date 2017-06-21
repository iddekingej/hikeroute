<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Vc\Lib\ImageList;

class Album extends ImageList{
    private $route;
    
    function __construct(Route $p_route)
    {
        $this->route=$p_route;
        parent::__construct($p_route->routeImages()->orderBy("position")->get());
    }

}
?>