<?php
namespace App\Exceptions;
/**
 * 
 * Exception used when file not found
 *
 */

class FileNotFoundException extends \Exception
{
    function __construct($p_name){
        __("File (:name) not found ",["name"=>$p_name]);
    }
}