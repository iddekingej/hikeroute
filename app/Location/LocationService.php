<?php 
declare(strict_types=1);
namespace App\Location;

use App\Lib\Control;
use App\Lib\GPXPoint;

class LocationService{

	private static $locationQueryService;
	
	/**
	 * the LocationQueryService objects queries the location query.
	 * Depending on the configuration the service object is created in this method.
	 */
	private static function initLocationQueryService()
	{
		$l_type=Control::locationServiceType();
		static::$locationQueryService=new $l_type();
	}
	
	/**
	 * Queries the location. This is a front end for
	 * the configured LocationQueryService
	 * 
	 * @param float $p_lat
	 * @param float $p_lon
	 * @return unknown
	 */
	static function query(float $p_lat,float $p_lon)
	{
		if(static::$locationQueryService===null){
			static::initLocationQueryService();
		}
		return static::$locationQueryService->query($p_lat,$p_lon);
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
		return self::query($p_point->lat,$p_point->lon);
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
	

}