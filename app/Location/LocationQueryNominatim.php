<?php
declare(strict_types=1);
namespace App\Location;
use App\Location\LocationQueryService;

class LocationQueryNominatim implements LocationQueryService
{
	/**
	 * Returns name information(City,county,state..) about location in ($p_lat,$p_lon)
	 *
	 *  @param real $p_lat Latitude of position (GPX position)
	 *  @param real $p_lon Longitude of position(GPX position)
	 */
	
	function query(float $p_lat,float $p_lon)
	{
		$l_curl=curl_init();
		curl_setopt($l_curl,CURLOPT_URL,"http://nominatim.openstreetmap.org/reverse?format=json&lat=$p_lat&lon=$p_lon&zoom=18&addressdetails=1");
		curl_setopt($l_curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($l_curl, CURLOPT_USERAGENT,"HikeSite/ AddressService");
		$l_return=curl_exec($l_curl);
		curl_close($l_curl);
		if($l_return !==false){
			return json_decode($l_return);
		}
		return null;
	}
	
}
