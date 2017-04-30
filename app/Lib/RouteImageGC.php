<?php 
declare(strict_types=1);
namespace App\Lib;
use App\Models\RouteImage;
use Doctrine\DBAL\Schema\View;

trait RouteImageGC
{
    function getCheckRouteImageEdit(int $p_id_routeImage,?RouteImage &$p_routeImage,?View &$p_view):bool
    {
        $p_view=NULL;
        $p_routeImage=RouteImage::find($p_id_routeImage);
        if($p_routeImage===NULL){
            $p_view=$this->displayError(__("Image not found"));
            return true;
        }
        $l_route=$p_routeImage->route;        
        if(!$l_route->canEdit(\Auth::user())){
            $p_routeImage=NULL;
            $p_view=$this->displayError(__("Not allowed to change this image"));
            return true;
        }
        return false;
    }
    
    function getCheckRouteImageShow(int $p_id_routeImage,?RouteImage &$p_routeImage,?View &$p_view):bool
    {
        $p_view=NULL;
        $p_routeImage=RouteImage::find($p_id_routeImage);
        if($p_routeImage===NULL){
            $p_view=$this->displayError(__("Image not found"));
            return true;
        }
        $l_route=$p_routeImage->route;      
        if(!$l_route->canShow(\Auth::user())){
            $p_routeImage=NULL;
            $p_view=$this->displayError(__("Not allowed to view this image"));
            return true;
        }
        return false;
    }
}