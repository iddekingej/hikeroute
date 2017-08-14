<?php
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\Engine\Data\DataLayer;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\MapData;

class UploadLayer implements DataLayer{
    function processData(?DataStore $p_parent):DataStore
    {
        return new MapData($p_parent,["form"=>["route"=>""],"url"=>Route("traces.save")]);        
    }
}