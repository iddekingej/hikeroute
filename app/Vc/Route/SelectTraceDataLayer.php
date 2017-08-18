<?php
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\RouteTraceTableCollection;
use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\MapData;

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