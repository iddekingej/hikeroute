<?php
declare(strict_types = 1);
namespace App\Lib;

/**
 * Summary information about a route
 */
class GPXInfo
{

    public $minLon = null;

    public $maxLon = null;

    public $minLat = null;

    public $maxLat = null;

    public $distance = 0;

    private $prevLat = null;

    private $prevLon = null;

    /**
     * Every time a point is read from the GPX file, this routine is called
     *
     * @param unknown $p_lat            
     * @param unknown $p_lon            
     */
    function update(float $p_lat, float $p_lon)
    {
        if ($this->minLat == null) {
            $this->minLat = $p_lat;
            $this->maxLat = $p_lat;
            $this->minLon = $p_lon;
            $this->maxLon = $p_lon;
        } else {
            $this->distance($this->prevLat, $this->prevLon, $p_lat, $p_lon);
            if ($this->minLon > $p_lon) {
                $this->minLon = $p_lon;
            } else if ($this->maxLon < $p_lon) {
                $this->maxLon = $p_lon;
            }
            if ($this->minLat > $p_lat) {
                $this->minLat = $p_lat;
            } else if ($this->maxLat < $p_lat) {
                $this->maxLat = $p_lat;
            }
        }
        $this->prevLat = $p_lat;
        $this->prevLon = $p_lon;
    }

    private function distance(float $p_lat1, float $p_lon1, float $p_lat2, float $p_lon2)
    {
        $l_r = 6371000;
        $l_f1 = $p_lat1 / 180 * pi();
        $l_f2 = $p_lat2 / 180 * pi();
        $l_df = ($p_lat2 - $p_lat1) / 180 * pi();
        $l_dl = ($p_lon2 - $p_lon1) / 180 * pi();
        $l_a = sin($l_df / 2) * sin($l_df / 2) + cos($l_f1) * cos($l_f2) * sin($l_dl / 2) * sin($l_dl / 2);
        $l_c = 2 * atan2(sqrt($l_a), sqrt(1 - $l_a));
        $this->distance += $l_r * $l_c;
    }
}