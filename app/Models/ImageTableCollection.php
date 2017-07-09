<?php
namespace App\Models;

use App\Lib\TableCollection;
use App\Lib\Magic;

class ImageUploadException extends \Exception
{
    
}
/**
 * Represents the Image table
 * 
 */
class ImageTableCollection extends TableCollection
{

    protected static $model = Image::class;

   /**
    * Add image to table 
    * 
    * @param String $p_file  File name which contain image data 
    * @param String $p_realName  The real file name (Use for determine mimetype)
    * @throws ValidationException
    * @return Image model
    */
    static function addImage(String $p_file,?String $p_realName):Image
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

