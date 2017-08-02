<?php
declare(strict_types = 1);
namespace App\Location;

use App\Location\LocationQueryService;

/**
 * Convert GPS location to description with the Nomatim service (Openstreemap)
 * ++NOTE++ Use nomatim.openstreemap.org only for testing !
 * 
 *
 */
class LocationQueryNominatim implements LocationQueryService
{

    /**
     * Service configuration.
     * $p_config can contain the following information
     * - url    : (mandatory) service url. Use [lat] and [lon] as location placeholder
     *            for ex:http://nominatim.openstreetmap.org/reverse?format=json&lat=[lat]&lon=[lon]&zoom=18&addressdetails=1
     * - fields : (optional) convert fields from json object to LocationResult object
     * 
     * @var Array $p_config service configuration
     */
    private $config;

    /**
     * Setup object 
     * 
     * @param array $p_config Configuration object.
     */
    function __construct(Array $p_config)
    {
        $this->config = $p_config;
    }

    /**
     * Convert the response to a LocationResult object.
     * Only fields given in $this->config["fields"] are copied to the result->address object
     * 
     * @param unknown $p_response
     * @return \App\Location\LocationResult|NULL
     */
    
    private function converToResult($p_response):?LocationResult
    {
        $l_resultAsObject=json_decode($p_response);
        if($l_resultAsObject === NULL){
            throw new LocationException("Invalid json response");
        }
        if(isset($l_resultAsObject->address)){
            
            $l_address=new LocationResult();
            
            foreach($l_resultAsObject->address as $l_field=>$l_name){
                
                if(isset($this->config["fields"])){
                    if(isset($this->config["fields"][$l_field])){
                        $l_normalizedField=$this->config["fields"][$l_field];
                    } else {
                        continue;
                    }
                } else {
                    $l_normalizedField=$l_field;
                }
                
                $l_address->addLocation($l_normalizedField,$l_name);
            }
            return $l_address;
        }
        return null;
    }
    
    /**
     * Returns location name by GPS location
     * result->address is a object, with fields defined in "adminLevel"
     * for ex result->address->country="Netherlands", result->address->city="Amsterdam"
     * 
     * @param float $p_lat         Latitude of position (GPX position)
     * @param real $p_lon          Longitude of position(GPX position)
     * @return LocationResult|NULL Location object or null when no valid response is returned
     */
    
    function query(float $p_lat, float $p_lon):?LocationResult
    {
        $l_url = $this->config["url"];
        $l_url = str_replace("[lat]", $p_lat, $l_url);
        $l_url = str_replace("[lon]", $p_lon, $l_url);
        $l_curl = curl_init();
        curl_setopt($l_curl, CURLOPT_URL, $l_url);
        curl_setopt($l_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($l_curl, CURLOPT_USERAGENT, "HikeSite/AddressService");
        $l_response = curl_exec($l_curl);
        if($l_response===false){
            throw new LocationException(curl_error($l_curl));
        }
        $l_rc=curl_getinfo($l_curl,CURLINFO_RESPONSE_CODE);
        if($l_rc !== 200){
            throw new LocationException("Request failed, response code $l_rc");
        }
        curl_close($l_curl);
        
        return $this->converToResult($l_response);
    }
}
