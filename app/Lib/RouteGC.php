<?php 
declare(strict_types=1);
namespace App\Lib;
use Illuminate\Contracts\View\View;
use App\Models\Route;

trait RouteGC{
    /**
     * Get route and returns an error view when route doesn't exists
     * or when the user has no right to edit the route
     * 
     * @param int $p_id_route  Id of route to look for
     * @param Route $p_route   Returns route, can be null when route doesn't exists or when user hasn't edit rights;
     * @param View $p_view     On failure (route doesn't exists or no edit rights) this parameter returns a error view
     * @return boolean         True on failure (p_view contains an error view) or false on success (p_route contains a route)
     */
    function getCheckRouteEdit(int $p_id_route,?Route &$p_route,?View &$p_view):bool
    {
        $p_route=Route::find($p_id_route);
        if($p_route==NULL){
            $p_view=$this->displayError(__("Route not found"));
            return true;
        }
        if(!$p_route->canEdit(\Auth::user())){
            $p_route=NULL;
            $p_view=$this->displayError(__("Not allowed to change this route"));
            return true;
        }
        return false;
    }
    
    /**
     * Get route and returns an error view when route doesn't exists
     * or when the user has no right to view the route
     *
     * @param int $p_id_route  Id of route to look for
     * @param Route $p_route   Returns route, can be null when route doesn't exists or when user hasn't view rights;
     * @param View $p_view     On failure (route doesn't exists or no view rights) this parameter returns a error view
     * @return boolean         True on failure (p_view contains an error view) or false on success (p_route contains a route)
     */
    
    
    function getCheckRouteShow(int $p_id_route,?Route &$p_route,?View &$p_view):bool
    {
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
}

