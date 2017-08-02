<?php
namespace App\Location;
/**
 * Converts gps location to location description (state/country/city)
 *
 */
interface LocationQueryService
{
    /**
     * Returns location name by GPS location
     * result->address is a object, with fields defined in "adminLevel"
     * for ex result->address->country="Netherlands", result->address->city="Amsterdam"
     *
     * @param float $p_lat  Latitude of position (GPX position)
     * @param real $p_lon    Longitude of position(GPX position)
     */
    
    function query(float $p_lat, float $p_lon):?LocationResult;
}