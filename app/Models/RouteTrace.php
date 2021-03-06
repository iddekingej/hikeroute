<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\GPXReader;
use App\Lib\GPXList;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * RouteTrace table=GPX File
 * 
 *
 */
class RouteTrace extends Model
{

    protected $locationsCached;

    protected $table = "routetraces";

    protected $fillable = [
        "id_routefile",
        "id_location",
        "distance",
        "startdate",
        "minlat",
        "maxlat",
        "minlon",
        "maxlon",
        "id_user",
        "start_lat",
        "start_lon",
        "end_lat",
        "end_lon"
    ];

    protected $dates = [
        "startdate"
    ];

    /**
     * This route trace belgong to this uses
     * 
     * @return BelongsTo
     */
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_user");
    }

    /**
     * Recalculate summary infornation about GPX trace files
     */
    function recalcGpx(): void
    {
        $l_content = $this->routeFile->gpxdata;
        $l_gpxParser = new GPXReader();
        $l_gpxList = $l_gpxParser->parse($l_content);
        $this->setByGPX($l_gpxList);
    }

    /**
     * Set gpx trace summary information by a GPXList object.
     *
     * @param GPXList $p_gpxList            
     */
    function setByGPX(GPXList $p_gpxList): void
    {
        $l_gpxInfo = $p_gpxList->getInfo();
        $this->minlon = $l_gpxInfo->minLon;
        $this->maxlon = $l_gpxInfo->maxLon;
        $this->minlat = $l_gpxInfo->minLat;
        $this->maxlat = $l_gpxInfo->maxLat;
        $this->distance = $l_gpxInfo->distance;
        
        $l_start=$p_gpxList->getStart();
        if($l_start){
            $this->start_lon = $l_start->lon;
            $this->start_lat = $l_start->lat;
        } else {
            $this->start_lon = null;
            $this->start_lat = null;
        }
        
        $l_end= $p_gpxList->getEnd();
        if($l_end){
            $this->end_lon = $l_end->lon;
            $this->end_lat = $l_end->lat;
        } else {
            $this->end_lon = null;
            $this->end_lat = null;
        }
        $this->startdate = $p_gpxList->getStart()->getDatePart();
        $this->save();
    }

    /**
     * Checks if route trace belongs to a route
     * @return bool  true - route trace belongs to a route / false - The route trace doesn't belong to a route 
     */
    function hasRoutes(): bool
    {
        return Route::where("id_routetrace", $this->id)->exists();
    }

    /**
     * Get related route
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function routes(): HasMany
    {
        return $this->hasMany(Route::class, "id_routetrace");
    }

    /**
     * Contents of the route file
     *
     * @return RouteFile
     */
    function routeFile(): BelongsTo
    {
        return $this->belongsTo(RouteFile::class, "id_routefile");
    }

    /**
     * Get description of location of the start point of a GPX route trace
     *
     * @return string
     */
    function getLocationString(): string
    {
        $l_return = "";
        foreach ($this->getLocations() as $l_location) {
            $l_return .= "/" . $l_location->location->name;
        }
        return $l_return;
    }
    /**
     * Get location of starting point
     * @return array
     */
    function getLocationsIndexed(): Array
    {
        return TraceLocationTableCollection::getByTraceTypeIndexed($this);
    }

    /**
     * Get cached location info belonging to route traces.
     * Return is a associative array. Index is the location type and value is the location description
     * 
     * @return array
     */
    function getLocationsIndexCached(): Array
    {
        if ($this->locationsCached === null) {
            $this->locationsCached = $this->getLocationsIndexed();
        }
        return $this->locationsCached;
    }

    /**
     * Get Location object belonging to the route trace by cached data
     *
     * @param $p_type Get
     *            location name by locationtype
     * @return Collection
     */
    function getLocationByTypeCached(String $p_type): string
    {
        $l_cached = $this->getLocationsIndexCached();
        if (isset($l_cached[$p_type])) {
            return $l_cached[$p_type]->name;
        }
        return "";
    }

    /**
     * Get Location object belonging to the route trace
     *
     * @return Collection
     */
    function getLocations(): Collection
    {
        return TraceLocationTableCollection::getByTrace($this);
    }

    /**
     * Delete a RouteTrace record and also all depended data
     */
    function deleteDepend(): void
    {
        TraceLocationTableCollection::deleteByTrace($this);
        $this->delete();
    }
/**
 * Determine if the user can view this trace
 * 
 * @param User $p_user
 * @return boolean
 */
    function canViewTrace(User $p_user)
    {
        return ($this->id_user == $p_user->id) || $p_user->getIsAdmin();
    }

/**
 * Determines if the user can use this trace in a route
 * 
 * @param User $p_user
 * @return boolean True is user in p_user can use this trace in a route
 */
    function canRoute(User $p_user)
    {
        return ($this->id_user == $p_user->id) || $p_user->getIsAdmin();
    }
/**
 * Determines if the user has delete rights for this TraceRoute
 * 
 * @param User $p_user
 * @return boolean   True user in $p_user as delete rights
 */
    function canDelete(User $p_user)
    {
        return ($this->id_user == $p_user->id) || $p_user->getIsAdmin();
    }
    
   
}
