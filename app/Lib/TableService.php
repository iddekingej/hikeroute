<?php 
namespace App\Lib;
class TableService
{
	static protected $model;
	
	static function indexArray($p_index,$p_field,$p_orderBy)
	{
		$l_model=static::$model;
		$l_data=$l_model::orderBy($p_orderBy,"asc")->get([$p_index,$p_field]);
		$l_indexedList=[];

		foreach($l_data as $l_row){
			$l_indexedList[$l_row->$p_index]=$l_row->$p_field;
		}
		return $l_indexedList;
	}
	
	static function chunk($p_num,callable $p_function)
	{
		$l_model=static::$model;
		$l_model::chunk($p_num,$p_function);
	}
}

?>