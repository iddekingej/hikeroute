<?php
declare(strict_types = 1);
namespace App\Lib;

use Carbon\Carbon;

class Localize
{

    static function shortDate(?Carbon $p_date)
    {
        if($p_date===null){
            return "";
        } else {
            return $p_date->format("d-m-Y");
        }
    }

    static function longDate(?Carbon $p_date)
    {
        if($p_date===null){
            return "";
        } else {
            return $p_date->format("d-m-Y h:i:s");
        }
    }
    
    static function meterToDistance(int $p_distance)
    {
        return (round($p_distance / 100) / 10) . "KM";
    }
}
?>