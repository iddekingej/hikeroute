<?php 
namespace App\Models;

use App\Lib\TableCollection;

class LocationTypeTableCollection extends TableCollection
{
	static protected $model=LocationType::class;
	static private $indexedList=null;
	
	/**
	 * Get list of location type indexed by index name
	 * 
	 * @return array
	 */
	static function getIndexedList():Array
	{
		if(self::$indexedList===null){
			self::$indexedList=self::indexArray("description","id", "sequence");
		}
		return self::$indexedList;
	}
	
}
?>