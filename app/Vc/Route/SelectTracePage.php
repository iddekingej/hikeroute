<?php 
declare(strict_types=1);
namespace App\Vc\Route;


use App\Vc\Lib\HtmlPage2;
use App\Vc\Lib\Note;
use App\Vc\Trace\TraceTable;

/**
 * When adding a route ,first this page is displayed in which the route
 * trace can be slected
 *
 */
class SelectTracePage extends HtmlPage2
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
    /**
     * Setup the page title
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage2::setup()
     */
    function setup():void
    {
        $this->title=__("Select a route trace");
        parent::setup();
    }
    
    /**
     * Displays the selection table 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage2::setupContent()
     */
    
    function setupContent():void
    {
        $this->top->add(new Note(__("Please, select first a previous uploaded route trace")),'100%',"0px");
        $this->top->add(new TraceTable($this->traces,$this->next,["id_route"=>$this->id_route]));
    }
}