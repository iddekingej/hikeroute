<?php
declare(strict_types = 1);
namespace App\Location;

use App\Lib\Control;
use App\Lib\GPXPoint;

class LocationService
{

    private static $locationQueryService;

    /**
     * Set location by configuration name
     * 
     * @param string $p_name
     *            Use this namend configuration item (defined in config/hr.php and configuration "locationServices"
     */
    static function setLocationService(String $p_name)
    {
        $l_data = \Config::get("hr.locationServices");
        $l_config = $l_data[$p_name];
        $l_type = $l_config["type"];
        static::$locationQueryService = new $l_type($l_config);
    }

    /**
     * the LocationQueryService objects queries the location query.
     * Depending on the configuration the service object is created in this method.
     */
    private static function initLocationQueryService()
    {
        static::setLocationService(Control::locationServiceType());
    }

    /**
     * Queries the location.
     * This is a front end for
     * the configured LocationQueryService
     *
     * @param float $p_lat            
     * @param float $p_lon            
     * @return unknown
     */
    static function query(float $p_lat, float $p_lon)
    {
        if (static::$locationQueryService === null) {
            static::initLocationQueryService();
        }
        return static::$locationQueryService->query($p_lat, $p_lon);
    }

    /**
     * Location info from position.
     * Same as @see AddressService::fromLocation
     *
     * @param GPXPoint $p_point            
     * @return \stdClass Location info
     */
    static function fromGpx(GPXPoint $p_point): ?LocationResult
    {
        return self::query($p_point->lat, $p_point->lon);
    }

    static function locationFromGPX(GPXPoint $p_point): ?LocationResult
    {
        return self::fromGPX($p_point);
    }
}