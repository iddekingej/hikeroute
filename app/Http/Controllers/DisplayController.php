<?php 
namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\View\View;

class DisplayController extends Controller
{
    private function getCheckRoute($p_id_route,?Route &$p_route,?View &$p_view):bool
    {
        $p_view=NULL;
        $p_route=Route::find($p_id_route);
        if($p_route==NULL){
            $p_view=$this->displayError(__("Route not found"));
            return true;
        }
        if(!$p_route->canShow(\Auth::user())){
            $p_route=NULL;
            $p_view=$this->displayError(__("Not allowed to view this route"));
            return true;
        }
        return false;
    }
    function album($p_id_route)
    {
        if($this->getCheckRoute($p_id_route,$l_route,$l_view)){
            return $l_view;
        }
        return view("display.album",["route"=>$l_route]);
    }
    
    function trace($p_id_route)
    {
        if($this->getCheckRoute($p_id_route,$l_route,$l_view)){
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
        if($this->getCheckRoute($p_id_route,$l_route,$l_view)){
            return $l_view;
        }        
        return View("display.overview", ["route"=>$l_route]);
    }
}
?>