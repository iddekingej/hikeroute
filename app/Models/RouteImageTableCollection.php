<?php
declare(strict_types = 1);
namespace App\Models;

use App\Lib\TableCollection;

class RouteImageTableCollection extends TableCollection
{

    protected static $model = RouteImage::class;
    
    static function addImage(Route $p_route,$p_file,$p_realName)
    {
        if(!$p_route->canEdit(\Auth::user())){
            throw new AuthenticationException(__("Not authorize to add images to this route"));
        }
        $l_content=file_get_contents($p_file);
        if($l_content===false){
            throw new ValidationException("image",__("Can't read uploaded file"));
        }
        $l_image=ImageTableCollection::addImage($p_file,$p_realName);
        $l_img=imagecreatefromstring(file_get_contents($p_file));
        $l_img=imagescale($l_img,80,160);
        $l_thumbName=tempnam(sys_get_temp_dir(),"hike");
        imagejpeg($l_img,$l_thumbName);
        $l_thumbnail=ImageTableCollection::addImage($l_thumbName,"test.jpg");
        $l_maxPos=RouteImage::where("id_route","=",$p_route->id)->max("position");
        return RouteImage::create(["id_route"=>$p_route->id,"position"=>$l_maxPos+1,"id_image"=>$l_image->id,"id_thumbnail"=>$l_thumbnail->id]);
    }
    
    static function renumberImages($p_route)
    {
        if(!$p_route->canEdit(\Auth::user())){
            throw new AuthenticationException(__("Not authorize to add images to this route"));
        }
        $l_cnt=1;
        foreach(RouteImage::where("id_route","=",$p_route->id)->orderBy("position")->get() as $l_route){
            if($l_route->position != $l_cnt){
                $l_route->position=$l_cnt;
                $l_route->save();
            }
            $l_cnt++;
        }
    }
}