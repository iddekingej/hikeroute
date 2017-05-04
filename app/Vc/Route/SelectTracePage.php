<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Vc\Lib\HtmlPage;
use App\Vc\Trace\TraceTable;

class SelectTracePage extends HtmlPage
{
    private $traces;
    private $next;
    private $id_route;
    
    function __construct($p_traces,$p_next,$p_id_route)
    {
        $this->traces=$p_traces;
        $this->next=$p_next;
        $this->id_route=$p_id_route;
        parent::__construct();
    }
    
    function setup()
    {
        $this->title=__("Select a route trace");
        parent::setup();
    }
    
    function content()
    {
	   $this->theme->page_Page->note(__("Please, select first a previous uploaded route trace"));
	   $l_traceTable=new TraceTable($this->traces,$this->next,["id_route"=>$this->id_route]);
	   $l_traceTable->display();
    }
}