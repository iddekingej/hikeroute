<?php 
namespace App\Models;

use App\Lib\TableService;

class LocationTypeService extends TableService
{
	static protected $model=LocationType::class;
	static private $indexedList=null;
	
	static function getIndexedList()
	{
		if(self::$indexedList===null){
			self::$indexedList=self::indexArray("description","id", "sequence");
		}
		return self::$indexedList;
	}
	
}
?>