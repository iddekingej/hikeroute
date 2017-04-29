<?php 
declare(strict_types=1);
namespace App\Vc\Trace;

use App\Vc\Lib\HtmlMenuPage;
use App\Vc\RouteTracesVC;

class ListPage extends HtmlMenuPage{
    private $traces;

    function __construct($p_traces)
    {
        $this->traces=$p_traces;
        parent::__construct();
    }
    
    function content()
    {
        RouteTracesVC::listTopMenu();
        $l_trace=new TraceTable($this->traces,"traces.show");
        $l_trace->display();
    }

}