<?php 
namespace App\Lib;
class TableCollection
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
	
	static function whereNull($p_field)
	{
		$l_model=static::$model;
		return $l_model::whereNull($p_field);
	}
	
	static function where($p_field,$p_comp,$p_value)
	{
		$l_model=static::$model;
		return $l_model::where($p_field,$p_comp,$p_value);
	}
	/**
	 * Todo whereget
	 * @param unknown $p_id
	 * @param unknown $p_comp
	 * @param unknown $p_value
	 * @param unknown $p_orderBy
	 */
	static function whereOrderBy($p_id,$p_comp,$p_value,$p_orderBy)
	{
		$l_model=static::$model;
		return $l_model::where($p_id,$p_comp,$p_value)->orderBy($p_orderBy)->get();
	}
}

?>