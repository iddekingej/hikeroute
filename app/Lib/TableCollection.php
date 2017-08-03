<?php
declare(strict_types = 1);
namespace App\Lib;


use Illuminate\Database\Eloquent\Collection;

class TableCollection extends Base
{

    protected static $model;

    static function indexArray($p_index, $p_field, $p_orderBy): Array
    {
        $l_data = static::$model::orderBy($p_orderBy, "asc")->get([
            $p_index,
            $p_field
        ]);
        $l_indexedList = [];
        
        foreach ($l_data as $l_row) {
            $l_indexedList[$l_row->$p_index] = $l_row->$p_field;
        }
        return $l_indexedList;
    }

    static function chunk($p_num, callable $p_function)
    {
        static::$model::chunk($p_num, $p_function);
    }
/**
 * Return all rows with fields are null
 * 
 * @param string  $p_field
 * @return unknown
 */
    static function whereNull(string $p_field)
    {
        return static::$model::whereNull($p_field);
    }

    static function whereIn($p_field, Array $p_data)
    {
        return static::$model::whereIn($p_field, $p_data);
    }
/**
 * Select from model with simple where clause 
 * Condition is  field <comp operator> Value
 * 
 * @param unknown $p_field   Table field part of condition 
 * @param unknown $p_comp    condition operator (e.q. =) 
 * @param unknown $p_value   value part of operator
 * 
 * @return unknown
 */
    static function where($p_field, $p_comp, $p_value)
    {
        return static::$model::where($p_field, $p_comp, $p_value);
    }

    /**
     * Where statement in combination with a order by
     * 
     * @param unknown $p_id            
     * @param unknown $p_comp            
     * @param unknown $p_value            
     * @param unknown $p_orderBy            
     */
    static function whereOrderBy($p_id, $p_comp, $p_value, $p_orderBy)
    {
        return static::$model::where($p_id, $p_comp, $p_value)->orderBy($p_orderBy)->get();
    }
    
    static function all():Collection
    {
        return static::$model::all();
    }
}

?>