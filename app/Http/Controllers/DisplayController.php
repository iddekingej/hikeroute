<?php 
namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\View\View;
use App\Lib\RouteGC;
use XMLView\View\ResourceView;

class DisplayController extends Controller
{
    
    use RouteGC;
    
    /**
     * Display the Album of a route
     * 
     * @param unknown $p_id_route
     * @return unknown
     */
    
    function album($p_id_route)
    {
        if($this->getCheckRouteShow($p_id_route,$l_route,$l_view)){
            return $l_view;
        }
        return view("display.album",["route"=>$l_route]);
    }
    
    /**
     * Display the trace of a route
     * @param unknown $p_id_route
     * @return unknown
     */
    
    function trace($p_id_route)
    {
        if($this->getCheckRouteShow($p_id_route,$l_route,$l_view)){
            return $l_view;
        }
        return new ResourceView("route/Trace.xml",["route"=>$l_route]);
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