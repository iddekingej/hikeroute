<?php
declare(strict_types = 1);
namespace App\Models;

use App\Lib\TableCollection;
use Illuminate\Database\Eloquent\Collection;

class TraceLocationTableCollection extends TableCollection
{

    protected static $model = TraceLocation::class;

    /**
     * Add TraceLocationRecord: Thats the connection between RouteTrace and location
     * Information
     *
     * @param RouteTrace $p_routeTrace
     *            Route Trace file
     * @param array $p_locations
     *            Array of Location objects
     */
    static function addTraceLocations(RouteTrace $p_routeTrace, Array $p_locations): void
    {
        foreach ($p_locations as $l_position => $l_location) {
            TraceLocation::create([
                "id_location" => $l_location->id,
                "id_routetrace" => $p_routeTrace->id,
                "position" => $l_position
            ]);
        }
    }

    /**
     * Get location belonging to a RouteTrace
     *
     * @param RouteTrace $p_routeTrace            
     * @return Collection|NULL
     */
    static function getByTrace(RouteTrace $p_routeTrace): ?Collection
    {
        return static::where("id_routetrace", "=", $p_routeTrace->id)->get();
    }

    static function byLocation($p_id)
    {
        return static::whereOrderBy("id_location", "=", $p_id, "id", "position");
    }

    /**
     */
    static function getByTraceTypeIndexed(RouteTrace $p_routeTrace): Array
    {
        $l_lts = self::getByTrace($p_routeTrace);
        $l_locations = [];
        if ($l_lts) {
            foreach ($l_lts as $l_lt) {
                $l_location = $l_lt->location;
                $l_index = $l_location->locationType->description;
                $l_locations[$l_index] = $l_location;
            }
        }
        return $l_locations;
    }

    /**
     * Delete all TraceLocation records belonging to a RouteTrace
     *
     * @param RouteTrace $p_routeTrace            
     */
    static function deleteByTrace(RouteTrace $p_routeTrace): void
    {
        static::where("id_routetrace", "=", $p_routeTrace->id)->delete();
    }
}

?>