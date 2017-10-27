<?php 
declare(strict_types=1);
namespace App\Vc\Album;

use XMLView\Engine\Data\DataLayer;
use App\Lib\Base;
use XMLView\Engine\Data\DataStore;
use XMLView\Engine\Data\MapData;


class ImageUploadLayer extends Base implements  DataLayer{
    function processData(DataStore $p_parent):DataStore
    {
       return new MapData($p_parent,["image"=>"","id"=>$p_parent->getValue("route")->id]);
       
    }
}
