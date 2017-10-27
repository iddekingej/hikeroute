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
use XMLView\View\ResourceView;

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
        return new ResourceView("album/Upload.xml",["route"=>$l_route]);        
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
            $l_routeImage->incViews();            
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
        \DB::transaction(
               function() use($l_route,$l_routeImage){
                    $l_routeImage->deleteAll();
                    RouteImageTableCollection::renumberImages($l_route);
               }
        );               
        return Redirect::route("images.edit",["id_route"=>$l_route->id]);
    }
    
    function onSummary($p_id_routeImage,$p_flag)
    {
        if($this->getCheckRouteImageEdit($p_id_routeImage,$l_routeImage,$l_view)){
            return $l_view;
        }
        $l_routeImage->onsummary=($p_flag==1)?1:0;
        $l_routeImage->save();                
        return Redirect::route("images.edit",["id_route"=>$l_routeImage->id_route]);
    }
    
    function move($p_id_routeImage,$p_direction)
    {
        if($this->getCheckRouteImageEdit($p_id_routeImage,$l_routeImage,$l_view)){
            return $l_view;
        }
        RouteImageTableCollection::movePosition($l_routeImage, $p_direction);
        return Redirect::route("images.edit",["id_route"=>$l_routeImage->id_route]);
    }
    
    function moveUp($p_id_routeImage)
    {
        return $this->move($p_id_routeImage,1);
    }
    
    function moveDown($p_id_routeImage)
    {
        return $this->move($p_id_routeImage,-1);
    }
    
    private function rotate($p_id_routeImage,$p_degrees)
    {
        $l_routeImage=RouteImage::find($p_id_routeImage);
        if($l_routeImage){
            \DB::transaction(
                function() use($l_routeImage,$p_degrees){
                    $l_routeImage->image->rotate($p_degrees);
                    $l_routeImage->image->save();
                    $l_routeImage->thumbnail->setImageIM($l_routeImage->image->makeIMThumbnail());
                    $l_routeImage->thumbnail->save();
                 }
                );
        }
        return Redirect::route("images.edit",["id_route"=>$l_routeImage->id_route]);
    }
    
    function rotr($p_id_routeImage)
    {
      return $this->rotate($p_id_routeImage,90);    
    }

    function rotl($p_id_routeImage)
    {
        return $this->rotate($p_id_routeImage,270);        
    }
    
}