<?php
declare(strict_types = 1);
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

    public $timestamp;

    function __construct(float $p_lat, float $p_lon, string $p_timestamp)
    {
        $this->lat = $p_lat;
        $this->lon = $p_lon;
        $this->timestamp = $p_timestamp;
    }

    /**
     * Get the date from the time stamp (time stamp is formated as 2016-05-28T10:53:25.000Z
     * This function returns everything before the 'T'= date.
     * When date value is empty or there is not 'T' in the date text a empty string is returned
     * 
     * @return string
     */
    function getDatePart(): ?string
    {
        $l_pos = strpos($this->timestamp, "T");
        if ($l_pos !== false) {
            return substr($this->timestamp, 0, $l_pos);
        }
        return null;
    }
}