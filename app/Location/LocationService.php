<?php
declare(strict_types = 1);
namespace App\Location;

use App\Lib\Control;
use App\Lib\GPXPoint;

/**
 * Get names (country, city,state etc..) from position.
 * This class class is a facade to the configured LocationQueryService type.
 *
 */
class LocationService
{

    private static $locationQueryService;

    /**
     * Set the  LocationQueryService type .
     * 
     * @param string $p_name
     *            Use this namend configuration item (defined in config/hr.php and configuration "locationServices"
     */
    
    static function setLocationService(String $p_name):void
    {
        $l_data = \Config::get("hr.locationServices");
        $l_config = $l_data[$p_name];
        $l_type = $l_config["type"];
        static::$locationQueryService = new $l_type($l_config);
    }

    /**
     * Set the locationQueryService type, depending on configuration.
     */
    
    private static function initLocationQueryService():void
    {
        static::setLocationService(Control::locationServiceType());
    }

    /**
     * Queries the location.
     * This is a front end for the configured LocationQueryService
     *
     * @param float $p_lat     Latitude of position 
     * @param float $p_lon     Longitude of position
     * @return LocationResult  Returns names of position
     */
    
    static function query(float $p_lat, float $p_lon):?LocationResult
    {
        if (static::$locationQueryService === null) {
            static::initLocationQueryService();
        }
        return static::$locationQueryService->query($p_lat, $p_lon);
    }

    /**
     * Location name by GPXPoiont.
     * Same as @see LocationService::query
     *
     * @param GPXPoint $p_point            
     * @return \stdClass Location info
     */

    static function locationFromGPX(GPXPoint $p_point): ?LocationResult
    {
        return self::query($p_point->lat, $p_point->lon);        
    }
}