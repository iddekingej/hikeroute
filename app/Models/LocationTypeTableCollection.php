<?php
namespace App\Models;

use App\Lib\TableCollection;
/**
 * This class represents the location table 
 *
 */
class LocationTypeTableCollection extends TableCollection
{

    protected static $model = LocationType::class;

    private static $indexedList = null;

    /**
     * Cache for getLocationType
     * @var Array
     */
    protected static $locationTypes = null;
    
    /**
     * Converts location name into location id
     *
     * @param String $p_description
     * @return mixed
     */
    static function getLocationType(String $p_description):int
    {
        if (self::$locationTypes == null) {
            self::$locationTypes = static::getIndexedList();
        }
        if(isset(self::$locationTypes[$p_description])){
            return self::$locationTypes[$p_description];
        } 
        return null;
    }
    
    /**
     * Get list of location type indexed by index name
     *
     * @return array
     */
    static function getIndexedList(): Array
    {
        if (self::$indexedList === null) {
            self::$indexedList = self::indexArray("description", "id", "sequence");
        }
        return self::$indexedList;
    }
}
?>