<?php
declare(strict_types=1);
namespace App\Location;

class LocationQueryDB implements LocationQueryService
{
	/**
	 * Service config
	 * 
	 * @var Array
	 */
	private $config;
	
	function __construct(Array $p_config)
	{
		$this->config=$p_config;
	}
	
	function query(float $p_lat,float $p_lon)
	{
		$l_connection=$this->config["connection"];
		$l_locations=\DB::connection($l_connection)->select(\DB::raw("select admin_level,name from planet_osm_polygon where ST_CONTAINS(way,ST_TRANSFORM(ST_GeomFromText('point('||:lon||' '||:lat||')',4326),3857)) and admin_level in ('2','4','8','10') "),["lon"=>$p_lon,"lat"=>$p_lat]);
		$l_tran=[2=>"country","4"=>"state","8"=>"city","10"=>"suburb"];
		$l_address=new \stdClass();
		foreach($l_locations as $l_location){
			$l_name=$l_tran[$l_location->admin_level];
			$l_address->$l_name=$l_location->name;
		}
		$l_result=new \stdClass();
		$l_result->address=$l_address;
		return $l_result;
	}
}