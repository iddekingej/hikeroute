<?php 
declare(strict_types=1);
namespace App\Lib;



use App\Exceptions\UnknownPropertyException;

class Base
{
    function __SET($p_name,$p_value)
    {
        throw new UnknownPropertyException($this, $p_name);
    }
    
    function __GET($p_name){
        throw new UnkownPropertyException($this,$p_name);
    }
}