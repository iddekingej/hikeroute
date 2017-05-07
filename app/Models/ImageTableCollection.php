<?php
namespace App\Models;

use App\Lib\TableCollection;
use App\Lib\Magic;

class ImageUploadException extends \Exception
{
    
}

class ImageTableCollection extends TableCollection
{

    protected static $model = Location::class;
    
    static function addImage($p_file,$p_realName):Image
    {     
        $l_content=file_get_contents($p_file);
        if($l_content===false){
            throw new ValidationException("image",__("Can't read uploaded file"));
        }
        $l_magic=new Magic();
        $l_mime=$l_magic->getMime($p_file,$p_realName);        
        return Image::create(["mimetype"=>$l_mime,"image"=>convert_uuencode($l_content)]);
    }
}

