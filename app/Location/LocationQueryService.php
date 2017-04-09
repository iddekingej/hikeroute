<?php
namespace App\Location;

interface LocationQueryService
{

    function query(float $p_lat, float $p_lon);
}