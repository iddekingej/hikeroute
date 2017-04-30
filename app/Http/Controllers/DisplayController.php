<?php 
namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\View\View;
use App\Lib\RouteGC;

class DisplayController extends Controller
{
    
    use RouteGC;
    
    function album($p_id_route)
    {
        if($this->getCheckRouteShow($p_id_route,$l_route,$l_view)){
            return $l_view;
        }
        return view("display.album",["route"=>$l_route]);
    }
    
    function trace($p_id_route)
    {
        if($this->getCheckRouteShow($p_id_route,$l_route,$l_view)){
            return $l_view;
        }
        return view("display.trace",["route"=>$l_route]);
    }
    
    /**
     * Display route:Map and all route data
     * also display edit controls when user is allowed to
     * edit the route *
     *
     * @param integer $p_id
     * @return \Illuminate\View\View View to display
     */
    function summary($p_id_route)
    {
        if($this->getCheckRouteShow($p_id_route,$l_route,$l_view)){
            return $l_view;
        }        
        return View("display.overview", ["route"=>$l_route]);
    }
}
?>