<?php
declare(strict_types = 1);
namespace App\Location;

use App\Location\LocationQueryService;

class LocationQueryNominatim implements LocationQueryService
{

    /**
     * Service configuration
     * 
     * @var Array
     */
    private $config;

    function __construct(Array $p_config)
    {
        $this->config = $p_config;
    }

    /**
     * Returns name information(City,county,state..) about location in ($p_lat,$p_lon)
     *
     * @param real $p_lat
     *            Latitude of position (GPX position)
     * @param real $p_lon
     *            Longitude of position(GPX position)
     */
    function query(float $p_lat, float $p_lon)
    {
        $l_url = $this->config["url"];
        $l_url = str_replace("[lat]", $p_lat, $l_url);
        $l_url = str_replace("[lon]", $p_lon, $l_url);
        $l_curl = curl_init();
        curl_setopt($l_curl, CURLOPT_URL, $l_url);
        curl_setopt($l_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($l_curl, CURLOPT_USERAGENT, "HikeSite/ AddressService");
        $l_return = curl_exec($l_curl);
        curl_close($l_curl);
        if ($l_return !== false) {
            return json_decode($l_return);
        }
        return null;
    }
}
