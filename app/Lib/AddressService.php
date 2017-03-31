<?php 
declare(strict_types=1);
namespace App\Lib;

class AddressService{
	/**
	 * Returns name information(City,county,state..) about location in ($p_lat,$p_lon)
	 * 
	 *  @param real $p_lat Latitude of position (GPX position)
	 *  @param real $p_lon Longitude of position(GPX position) 
	 */
	static function fromLocation($p_lat,$p_lon)
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
	
	static function locationStringFromGPX(GPXPoint $p_point):?Address
	{
		$l_location=self::fromGPX($p_point);
		
		$l_address=new Address();
		if($l_location){
			$l_data=$l_location->address;
			if(isset($l_data->country)){
				$l_address->data["country"]=$l_data->country;
				$l_address->fullname .= "/".$l_data->country;
			}
			if(isset($l_data->state)){
				$l_address->data["state"]=$l_data->state;
				$l_address->fullname .= "/".$l_data->state;
			}
			if(isset($l_data->city)){
				$l_address->data["city"]=$l_data->city;
				$l_address->fullname .= "/".$l_data->city;
			}
			if(isset($l_data->suburb)){
				$l_address->data["suburb"]=$l_data->suburb;
				$l_address->fullname .= "/".$l_data->suburb;
			}

		}
		return $l_address;
			
	}
	
	/**
	 * Location info from position.
	 * Same as @see AddressService::fromLocation
	 * 
	 * @param GPXPoint $p_point
	 * @return \stdClass Location info
	 */
	
	static function fromGpx(GPXPoint $p_point):?\stdClass
	{
		return self::fromLocation($p_point->lat,$p_point->lon);
	}
}