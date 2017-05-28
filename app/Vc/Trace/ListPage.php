<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\TopMenu;
use App\Vc\Lib\HtmlMenuPage2;

class ListPage extends HtmlMenuPage2{
    private $traces;

    function __construct($p_traces)
    {
        $this->traces=$p_traces;
        parent::__construct();
    }
    
    function setup()
    {
        $this->setCurrentTag("traces");
        $this->title=__("Route traces");
        parent::setup();
    }
    function setupContent()
    {
        $l_menu=new TopMenu();
        $l_menu->addMenuItem("traces.upload", [], __("Upload new gpx"));
        $this->top->add($l_menu,"100%","0px");
        $this->top->add(new TraceTable($this->traces,"traces.show",[]));
    }

}