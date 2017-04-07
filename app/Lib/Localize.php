<?php
declare(strict_type=1);
namespace App\Lib;

use Carbon\Carbon;

class Localize{
	
	static function shortDate(Carbon $p_date)
	{
		return $p_date->format("d/m/Y");
	}
	
	static function meterToDistance(int $p_distance)
	{
		return (round($p_distance/100)/10)."KM";
	}
}
?>