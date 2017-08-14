<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\Engine\Gui\XMLResourcePage;
use App\Vc\Lib\Engine\Data\MapData;
use App\Vc\Lib\Engine\Data\DataStore;


class UploadPage extends XMLResourcePage{
    private $errors;

    function __construct($p_errors){
        $this->errors=$p_errors;               
        $this->setResourceFile("trace/Upload.xml");        
        parent::__construct();
    }

    function makeData(?DataStore $p_parent)
    {
        return new MapData($p_parent,[]);        
    }
    
    function setup():void
    {
        $this->title=__("Upload route");
        parent::setup();
    }
        
}