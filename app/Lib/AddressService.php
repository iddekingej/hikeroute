<?php 
namespace App\Lib;

class AddressService{
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
	
	static function locationStringFromGPX(GPXPoint $p_point)
	{
		$l_location=self::fromGPX($p_point);
		$l_result=[];
		if($l_location){
			$l_data=$l_location->address;
			if(isset($l_data->suburb)){
				$l_result[]=$l_data->suburb;
			}
			if(isset($l_data->city)){
				$l_result[]=$l_data->city;
			}
			if(isset($l_data->state)){
				$l_result[]=$l_data->state;
			}
			if(isset($l_data->country)){
				$l_result[]=$l_data->country;
			}
			return implode("/", $l_result);		
		}
		return "";
	}
	
	static function fromGpx(GPXPoint $p_point)
	{
		return self::fromLocation($p_point->lat,$p_point->lon);
	}
}