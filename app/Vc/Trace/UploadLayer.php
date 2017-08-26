<?php
declare(strict_types=1);
namespace App\Vc\Trace;


use XMLView\Engine\Data\DataLayer;
use XMLView\Engine\Data\MapData;
use XMLView\Engine\Data\DataStore;

class UploadLayer implements DataLayer{
    function processData(?DataStore $p_parent):DataStore
    {
        return new MapData($p_parent,["form"=>["route"=>""],"url"=>Route("traces.save"),"routefile"=>""]);        
    }
}