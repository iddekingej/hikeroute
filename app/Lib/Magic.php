<?php
declare(strict_types=1);
namespace App\Lib;

use App\Exceptions\FileNotFoundException;

/**
 * Get File type from magic and extension
 *
 */

class Magic extends Base{
    private static $data=NULL;

    function __construct()
    {
        if(self::$data===null){
            self::$data=require("MagicData.php");
        }
    }

    /**
     * p_data contains data (number) and compares this with str
     * 
     * @param Array $p_data
     * @param String $p_str
     * @return boolean
     */
    private function comp(Array $p_data,string $p_str):bool
    {
        $l_end=count($p_data);
        for($l_cnt=0;$l_cnt<$l_end;$l_cnt++){
            if(chr($p_data[$l_cnt]) != $p_str[$l_cnt]){
                return false;
            }
        }
        return true;
    }
    
    /**
     * Find the mime type by magick 
     * 
     * @param string  $p_file
     * @throws Exception
     * @return String|NULL
     */

    function findMimeByMagick($p_file):?int
    {
        $l_convFile=$p_file;
        $l_fileHandle=fopen($l_convFile,"rb");
        if($l_fileHandle===false){
            throw new FileNotFoundException($p_file);
        }
        $l_dataZero=NULL;
        foreach(self::$data as $l_key=>$l_info){
            if($l_info[0]){
                $l_bin=$l_info[0];
                if($l_info[2]!=0){
                    fseek($l_fileHandle,$l_info[2]);
                    $l_data=fread($l_fileHandle,count($l_bin))    ;
                } else {
                    if($l_dataZero===null){
                        $l_dataZero=fread($l_fileHandle,16);
                    }
                    $l_data=$l_dataZero;
                }                
                
                if(count($l_bin)<=strlen($l_data) && $this->comp($l_bin,$l_data)){
                    fclose($l_fileHandle);
                    return $l_key;                        
                }
            }
        }
        fclose($l_fileHandle);
        return NULL;
        
    }


    function getAllowedExtensions($p_file)
    {
        $l_no=$this->findMimeByMagick($p_file);
        if(!is_null($l_no)){
            $l_info=self::$data[$l_no];
            if(is_array($l_info[1])){
                return array_keys($l_info[1]);
            } else {
                return $l_info[3];
            }
        }
        return NULL;
    }

    function getSupportedMimeTypes():Array
    {
        $l_return=[];
        foreach(self::$data  as $l_info){
            if(is_array($l_info[1])){
                foreach($l_info[1] as $l_mime){
                    $l_return[]=$l_mime;
                }
            } else {
                $l_return[]=$l_info[1];
            }
        }
        
        return array_unique($l_return);
    }
    
    function getMime($p_file,$p_realName=null):?string
    {

        $l_ext="";
        $l_file=$p_file;
        if($p_realName){
            $l_file=$p_realName;
        }
        $l_cnt=strlen($l_file)-1;
        while($l_cnt>0 && $l_file[$l_cnt] !="." && $l_file[$l_cnt] != "\\"){
            $l_ext =$l_file[$l_cnt].$l_ext;
            $l_cnt--;
        }

        if($l_file[$l_cnt] =="."){
            $l_ext=".".$l_ext;
            $l_ext=strtolower($l_ext);
        } else {
            $l_ext="";
        }
        $l_no=$this->findMimeByMagick($p_file);
        if(!is_null($l_no)){
            $l_info=self::$data[$l_no];
            
            if(is_array($l_info[1])){
                if(isset($l_info[1][$l_ext])){
                    return $l_info[1][$l_ext];
                }
                return NULL;
            }
            return $l_info[1];
        }
        return NULL;
    }

}
?>