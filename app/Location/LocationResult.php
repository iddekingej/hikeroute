<?php
declare(strict_types = 1);
namespace App\Location;

/**
 *  Contains result of LocationQueryService
 *
 */

class LocationResult
{
    /**
     * stdClass object.
     * This object contains the address information.
     * field names depends on the service configuration
     * ToDo: make this field private
     * 
     * @var stdObject
     */
    public $address;
    
    function __construct()
    {
        $this->address=new \stdClass();
    }
    
    /**
     * 
     * @param string $p_name
     * @param unknown $p_value
     */
    function addLocation(string $p_name,$p_value):void
    {
        $this->address->$p_name = $p_value;
    }
}