<?php
namespace App\Models;

use App\Lib\TableCollection;
use Illuminate\Database\Eloquent\Collection;

class LocationTableCollection extends TableCollection
{

    protected static $model = Location::class;

    protected static $locationTypes = null;

    /**
     * TODO move to LocationTypeTable
     * Converts location name into location id 
     *
     * @param String $p_description            
     * @return mixed
     */
    private static function getLocationType(String $p_description):int
    {
        if (self::$locationTypes == null) {
            self::$locationTypes = LocationTypeTableCollection::getIndexedList();
        }
        return self::$locationTypes[$p_description];
    }

    /**
     * Checks if location combination ($p_id_parent,$p_type,$p_name)
     * is already in the database, the location is inserted in the database
     * Return an object representing this location.
     *
     * @param unknown $p_id_parent
     *            Parent location. Null when location has not parent location
     * @param unknown $p_type
     *            Location type name ("city","suburb","country" etc..)
     * @param unknown $p_name
     *            Location name
     * @return Location Location object
     */
    private static function getLocationModel(?int $p_id_parent, string $p_type, string $p_name)
    {
        $l_id = self::getLocationType($p_type);
        $l_model = self::$model;
        
        $l_where = $l_model::where("id_locationtype", "=", $l_id)->where("name", "=", $p_name);
        if ($p_id_parent === null) {
            $l_where = $l_where->whereNull("id_parent");
        } else {
            $l_where = $l_where->where("id_parent", "=", $p_id_parent);
        }
        $l_row = $l_where->get();
        if ($l_row->isEmpty()) {
            return $l_model::create([
                "id_parent" => $p_id_parent,
                "id_locationtype" => $l_id,
                "name" => $p_name
            ]);
        } else {
            
            return $l_row->first();
        }
    }

    /**
     * The $p_data contains the location tree (country->state->city->suburb).
     * This data is inserted in the database (if it doesn't exists yet) and returns
     * an array with objects representing each location tree item.
     *
     * @param array $p_data
     *            Associative Array of location name (Location type=>location name)
     * @return array Array of locations
     */
    static function getLocation(Array $p_data): Array
    {
        $l_id_parent = null;
        $l_location = null;
        $l_locations = [];
        foreach ($p_data as $l_type => $l_name) {
            $l_location = self::getLocationModel($l_id_parent, $l_type, $l_name);
            $l_locations[] = $l_location;
            $l_id_parent = $l_location->id;
        }
        return $l_locations;
    }

    /**
     * get the "top" locations (with out parent locations)=list of countries.
     * 
     * @return array
     */
    static function topLocations(): Array
    {
        return static::whereNull("id_parent")->orderBy("name")->get();
    }

    /**
     * Translate location id's to locations
     * 
     * @param array $p_ids            
     * @return array
     */
    static function getLocationsByArray(Array $p_ids): Collection
    {
        return static::whereIn("id", $p_ids)->get();
    }
}

