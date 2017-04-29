<?php
namespace App\Http\Controllers;


use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\ImageTableCollection;
use Illuminate\Support\Facades\Redirect;
use App\Exceptions\ValidationException;
use Validator;
use App\Models\RouteImageTableCollection;
use App\Models\RouteImage;
;

class ImageController extends Controller
{
    public function addImage($p_id)
    {
        $this->checkInteger($p_id);
        $l_route= Route::findOrFail($p_id);
        if(!$l_route->canEdit(\Auth::user())){
            return $this->displayError(__("Not allowed to add images to this route"));
        }
        return View("routes.image",["route"=>$l_route]);
    }
    
    public function saveImage(Request $p_request)
    {
        try{
        $l_rules=[
               "id"=>["required","integer"]
            ,  "image"=>["required","file"]
        ];
        
        $l_validator = Validator::make($p_request->all(), $l_rules);
        if ($l_validator->fails()) {
            return Redirect::route("images.add",["p_id"=> $p_request->input("id")])->withErrors($l_validator)->withInput($p_request->all());
        }
        
        $l_route=Route::findOrFail($p_request->input("id"));
        try{
            RouteImageTableCollection::addImage($l_route, $p_request->image->path(), $p_request->image->getClientOriginalName());
        }catch(ValidationException $l_e){
            echo $l_e->getMessage();
            return Redirect::route("images.add",[])->withErrors($l_e->getData())->withInput($p_request->all());
        }
        }catch(\Exception $l_e){
        }
        return Redirect::route("routes.album",["id"=>$l_route->id]);
    }
    
    private function displayImageGen($p_id_route_image,bool $p_thumbnail)
    {
        $this->checkInteger($p_id_route_image);
        $l_routeImage=RouteImage::find($p_id_route_image);
        if(!$l_routeImage){
            return View("other.error",["message",__("Image not found")]);
        }
        if(!$l_routeImage->route->canShow(\Auth::user())){
            return $this->displayError(__("Not allowed to view this image"));
        }
        if($p_thumbnail){
            $l_image=$l_routeImage->thumbnail;
        } else {
            $l_image=$l_routeImage->image;
        }
        return response($l_image->decodedImage())->header("Content-Type",$l_image->mimetype);
    }
    
    public function displayImage($p_id_route_image)
    {
        return $this->displayImageGen($p_id_route_image,false);
    }
    
    public function displayThumbnail($p_id_route_image)
    {
        return $this->displayImageGen($p_id_route_image,true);
    }
}