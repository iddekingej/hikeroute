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
     * This array contains the address information.
     * Data depends on the service configuration 
     * @var array
     */
    private $address=[];
    
    
    /**
     * 
     * @param string $p_name
     * @param unknown $p_value
     */
    function addLocation(string $p_name,$p_value):void
    {
        $this->address[$p_name] = $p_value;
    }
    
    function getLocation(string $p_name)
    {
        return $this->address[$p_name];
    }
    
    function hasLocation(string $p_name):bool
    {
        return array_key_exists($p_name,$this->address);
    }
    
    function getLocationData()
    {
        return $this->address;
    }    
    
    function getFullName()
    {
        $l_fullName="";
        foreach($this->address as $l_name){
            $l_fullName = "/$l_name".$l_fullName;
        }
        return $l_fullName;
    }
}