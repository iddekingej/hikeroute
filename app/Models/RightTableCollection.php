<?php 
namespace App\Models;

use App\Lib\TableCollection;

class RightTableCollection extends TableCollection
{
    protected static $model = Right::class;
    
    
    public static function getRightsSelectionArray(): array
    {
        $l_rights = [];
        foreach (static::all() as $l_right) {
            $l_rights[$l_right->id] = [
                $l_right,
                false
            ];
        }
        return $l_rights;
    }
    
}