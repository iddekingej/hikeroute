<?php
declare(strict_types = 1);
namespace App\Models;

use App\Lib\TableCollection;

class RouteImageTableCollection extends TableCollection
{

    protected static $model = RouteImage::class;
    /**
     * TODO make RouteImage::canEdit
     * 
     * Check if image can be edited or else raise exception
     * 
     * @param Route $p_route
     * @throws AuthenticationException
     */
    static function checkCanEdit(Route $p_route)
    {
        if(!$p_route->canEdit(\Auth::user())){
            throw new AuthenticationException(__("Not authorize to add images to this route"));
        }
        
    }
    /**
     * @todo move to Route and RouteTableCollection
     * @param Route $p_route
     * @param String $p_file
     * @param String $p_realName
     * @throws ValidationException
     * @return unknown
     */
    static function addImage(Route $p_route,String $p_file,?String $p_realName)
    {
        static::checkCanEdit($p_route);
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
    
    /**
     * Renumber images after modification
     * 
     * @param Route $p_route Renumber images belonging to this route
     */
    static function renumberImages(Route $p_route)
    {
        static::checkCanEdit($p_route);
        $l_cnt=1;
        foreach(RouteImage::where("id_route","=",$p_route->id)->orderBy("position")->get() as $l_route){
            if($l_route->position != $l_cnt){
                $l_route->position=$l_cnt;
                $l_route->save();
            }
            $l_cnt++;
        }
    }
    
    /**
     * Change image position.
     * 
     * @param RouteImage $p_routeImage Change position of this routeImage
     * @param unknown $p_direction   +1 =>Up -1 =>down
     */
    static function movePosition(RouteImage $p_routeImage,$p_direction)
    {
        $l_route=$p_routeImage->route;
        static::checkCanEdit($l_route);
        if($p_routeImage->position<=1 && $p_direction==-1){
            return;
        }
        $l_maxPos=RouteImage::where("id_route","=",$l_route->id)->max("position");
        if($p_routeImage->position>=$l_maxPos && $p_direction==1){
            return;
        }
        \DB::statement(\DB::raw("update route_images set position=2*:cur+:dir-position where id_route=:id_route and position in (:cur,:cur+:dir)"),
                ["cur"=>$p_routeImage->position,"dir"=>$p_direction,"id_route"=>$l_route->id]);
    }
}