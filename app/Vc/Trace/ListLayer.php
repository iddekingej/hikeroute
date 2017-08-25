<?php
declare(strict_types=1);
namespace App\Vc\Trace;

use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\MapData;
use App\Models\RouteTraceTableCollection;

class ListLayer implements DataLayer{
    function processData(DataStore $p_parent):DataStore{
        $l_map=new MapData($p_parent);
        $l_map->setValue("traces", RouteTraceTableCollection::getByUser(\Auth::user()));
        return $l_map;
    }
}