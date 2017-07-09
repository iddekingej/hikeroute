<?php
namespace App\Models;

use App\Lib\GPXReader;
use App\Lib\Control;
use App\Lib\TableCollection;
use App\Location\LocationService;
use Illuminate\Database\Eloquent\Collection;

class RouteTraceException extends \Exception
{

    function __construct($p_msg, $p_previous)
    {
        parent::__construct($p_msg, 1, $p_previous);
    }
}

/**
 * Represent RouteTrace Table
 *
 */
class RouteTraceTableCollection extends TableCollection
{

    protected static $model = RouteTrace::class;
/**
 * Upload a new GPXFile to a RouteTrace 
 * 
 * @param RouteTrace $p_routeTrace  Uploade GPx file to this trace
 * @param string $p_gpxData         GPX data to upload to tace
 */
    public static function updateGpxFile(RouteTrace $p_routeTrace, string $p_gpxData): void
    {
        $l_routeFile = $p_routeTrace->routeFile;
        $l_routeFile->gpxdata = $p_gpxData;
        $l_routeFile->save();
        $l_gpxParser = new GPXReader();
        $l_gpxList = $l_gpxParser->parse($p_gpxData);
        if (Control::addressServiceEnabled()) {
            $l_locData = LocationService::locationStringFromGPX($l_gpxList->getStart());
            $l_locations = LocationTableCollection::getLocation($l_locData->data);
            if ($l_locations !== null) {
                $l_location = end($l_locations);
                $l_id_location = $l_location->id;
            } else {
                $l_id_location = null;
            }
        } else {
            $l_id_location = null;
        }
        
        $p_routeTrace->id_location = $l_id_location;
        $p_routeTrace->setByGPX($l_gpxList);
    }
/**
 * Upload new GPX file and create a RouteTrace object
 * 
 * @param string $p_gpxData
 * @return RouteTrace 
 */
    public static function addGpxFile(string $p_gpxData): RouteTrace
    {
        $l_gpxParser = new GPXReader();
        $l_gpxList = $l_gpxParser->parse($p_gpxData);
        if (Control::addressServiceEnabled()) {
            $l_locData = LocationService::locationStringFromGPX($l_gpxList->getStart());
            $l_locations = LocationTableCollection::getLocation($l_locData->data);
            if ($l_locations !== null) {
                $l_location = end($l_locations);
                $l_id_location = $l_location->id;
            } else {
                $l_id_location = null;
            }
        } else {
            $l_id_location = null;
            $l_locations = null;
        }
        $l_routeFile = RouteFile::create([
            "gpxdata" => $p_gpxData
        ]);
        $l_info = $l_gpxList->getInfo();
        
        $l_trace = RouteTrace::create([
            "id_routefile" => $l_routeFile->id,
            "id_location" => $l_id_location,
            "startdate" => $l_gpxList->getStart()->getDatePart(),
            "minlon" => $l_info->minLon,
            "maxlon" => $l_info->maxLon,
            "minlat" => $l_info->minLat,
            "maxlat" => $l_info->maxLat,
            "distance" => $l_info->distance,
            "id_user" => \Auth::user()->id
        ]);
        if ($l_locations) {
            TraceLocationTableCollection::addTraceLocations($l_trace, $l_locations);
        }
        return $l_trace;
    }

    /**
     * Get all the traces owner by user
     * 
     * @param User $p_user
     * @return Collection|NULL
     */
    static function getByUser(User $p_user): ?Collection
    {
        return self::where("id_user", "=", $p_user->id)->orderBy("startdate")->get();
    }
    
    /**
     * Checks if a user  owns a trace
     * 
     * @param User $p_user
     * @return bool True - User owns a trace
     */
    static function userHasRouteTraces(User $p_user): bool
    {
        return !(self::where("id_user", "=", $p_user->id)->limit(1)
        ->get()
        ->isEmpty());
    }
}

?>