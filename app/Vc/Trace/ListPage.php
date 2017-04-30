<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\HtmlMenuPage;
use App\Vc\RouteTracesVC;
use App\Vc\Lib\TopMenu;

class ListPage extends HtmlMenuPage{
    private $traces;

    function __construct($p_traces)
    {
        $this->traces=$p_traces;
        parent::__construct();
    }
    
    function content()
    {
        $l_menu=new TopMenu();
        $l_menu->addMenuItem("traces.upload", [], __("Upload new gpx"));
        $l_menu->display();
        $l_trace=new TraceTable($this->traces,"traces.show",[]);
        $l_trace->display();
    }

}