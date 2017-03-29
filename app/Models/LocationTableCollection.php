<?php 
namespace App\Models;

use App\Lib\TableCollection;

class LocationTableCollection extends TableCollection
{
	static protected $model=Location::class;
	static protected $locationTypes=null;
	
	private static function getLocationType($p_description)
	{
		if(self::$locationTypes==null){
			self::$locationTypes=LocationTypeTableCollection::getIndexedList();
		}
		return self::$locationTypes[$p_description];
	}
	
	private static function getLocationModel($p_id_parent,$p_type,$p_name)
	{
		$l_id=self::getLocationType($p_type);
		$l_model=self::$model;
	
		$l_where=$l_model::where("id_locationtype","=",$l_id)
		               ->where("name","=",$p_name);
		if($p_id_parent===null){
			$l_where=$l_where->whereNull("id_parent");	
		} else {
			$l_where=$l_where->where("id_parent","=",$p_id_parent);
		}
		$l_row=$l_where->get();
		if($l_row->isEmpty()){
			return $l_model::create(["id_parent"=>$p_id_parent,"id_locationtype"=>$l_id,"name"=>$p_name]);
		} else {
			
			return $l_row->first();
		}
	}
	
	static function getLocation(Array $p_data)
	{
		$l_id_parent=null;
		$l_location=null;
		foreach($p_data as $l_type=>$l_name){
			$l_location=self::getLocationModel($l_id_parent,$l_type,$l_name);
			$l_id_parent=$l_location->id;
		}
		return $l_location;
	}
	
	static function topLocations()
	{
		return static::whereNull("id_parent")->orderBy("name")->get();
	}
	
	static function getLocationsByArray(Array $p_ids)
	{
		$l_locations=[];
		foreach($p_ids as $l_id){
			$l_locations[]=Location::findOrFail($l_id);
		}
		return $l_locations;
	}
	
	static function getLocationsByParent($p_id_parent)
	{
		return self::whereOrderBy("id_parent", "=", $p_id_parent,"name");
	}
}

