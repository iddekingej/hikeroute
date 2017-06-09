<?php 
declare(strict_types=1);
namespace App\Lib;

use App\Exceptions\UnknownPropertyException;

/**
 * Base objects for all other object
 * Contains __SET and __GET to protect for setting and getting non existing properties
 *
 */
class Base
{
    final function __SET($p_name,$p_value)
    {
        throw new UnknownPropertyException($this, $p_name);
    }
    
    final function __GET($p_name){
        throw new UnkownPropertyException($this,$p_name);
    }
}