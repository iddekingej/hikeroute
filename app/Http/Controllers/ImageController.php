<?php
namespace App\Http\Controllers;


use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Exceptions\ValidationException;
use Validator;
use App\Models\RouteImageTableCollection;
use App\Models\RouteImage;
use App\Lib\RouteGC;
use App\Lib\RouteImageGC;

class ImageController extends Controller
{
    use RouteGC;
    use RouteImageGC; 

    public function addImage($p_id)
    {
        $this->checkInteger($p_id);
        if($this->getCheckRouteEdit($p_id, $l_route, $l_view)){
            return $l_view;
        }
        return View("album.image",["route"=>$l_route]);
    }
    
    
    function saveImage(Request $p_request)
    {
        $l_rules=[
               "id"=>["required","integer"]
            ,  "image"=>["required","file"]
        ];
        
        $l_validator = Validator::make($p_request->all(), $l_rules);
        
        if ($l_validator->fails()) {
            return Redirect::route("images.add",["p_id"=> $p_request->input("id")])->withErrors($l_validator)->withInput($p_request->all());
        }
        
        if($this->getCheckRouteEdit($p_request->input("id"), $l_route, $l_view)){
            return $l_view;
        }

        try{
            RouteImageTableCollection::addImage($l_route, $p_request->image->path(), $p_request->image->getClientOriginalName());
        }catch(ValidationException $l_e){
            return Redirect::route("images.add",[])->withErrors($l_e->getData())->withInput($p_request->all());
        }
        return Redirect::route("display.album",["id"=>$l_route->id]);
    }
    
    private function displayImageGen($p_id_route_image,bool $p_thumbnail)
    {
        $this->checkInteger($p_id_route_image);
        $l_routeImage=RouteImage::find($p_id_route_image);

        if($this->getCheckRouteImageShow($p_id_route_image, $l_routeImage, $l_view)){
            return $l_view;
        }
        if($p_thumbnail){
            $l_image=$l_routeImage->thumbnail;
        } else {
            $l_image=$l_routeImage->image;
        }
        return response($l_image->decodedImage())->header("Content-Type",$l_image->mimetype);
    }
    
    function displayImage($p_id_route_image)
    {
        return $this->displayImageGen($p_id_route_image,false);
    }
    
    function displayThumbnail($p_id_route_image)
    {
        return $this->displayImageGen($p_id_route_image,true);
    }
    
    function editAlbum($p_id_route)
    {
        if($this->getCheckRouteEdit($p_id_route,$l_route, $l_view)){
            return $l_view;
        }
        return View("album.edit",["route"=>$l_route]);
    }
    
    function delImage($p_id_routeImage)
    {        
        if($this->getCheckRouteImageEdit($p_id_routeImage,$l_routeImage,$l_view)){
            return $l_view;
        }
        $l_route=$l_routeImage->route;
        $l_routeImage->deleteAll();
        return Redirect::route("display.album",["id_route"=>$l_route->id]);
    }
}