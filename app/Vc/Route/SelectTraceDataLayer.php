<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\Engine\Data\DataLayer;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\MapData;
use App\Models\RouteTraceTableCollection;

class SelectTraceDataLayer implements DataLayer{
    function processData(?DataStore $p_parent):DataStore
    {
        return new MapData($p_parent,[
            "traces"=>RouteTraceTableCollection::getByUser(\Auth::user())
            ,   "route"=>$p_parent->getValue("next")
            ,   "params"=>["id_route"=>$p_parent->getValue("id_route")]
        ]);
    }
}   