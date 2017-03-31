<?php 
namespace App\Models;

use App\Lib\TableCollection;

class LocationTypeTableCollection extends TableCollection
{
	static protected $model=LocationType::class;
	static private $indexedList=null;
	
	static function getIndexedList():Array
	{
		if(self::$indexedList===null){
			self::$indexedList=self::indexArray("description","id", "sequence");
		}
		return self::$indexedList;
	}
	
}
?>