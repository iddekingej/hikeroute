<?php 
namespace App\Lib;

/**
 * One cooridate from the GPX file
 * GPXPoint->lat Latitude
 * GPXPoint->lon Longitude
 */
class GPXPoint
{
	public $lat;
	public $lon;

	function __construct($p_lat,$p_lon)
	{
		$this->lat=$p_lat;
		$this->lon=$p_lon;
	}
}