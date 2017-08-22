<?php 
declare(strict_types=1);
namespace App\Vc\Route;


use App\Vc\Lib\HtmlPage2;
use App\Vc\Lib\Engine\Gui\XMLResourcePage;
use XMLView\Engine\Data\DataStore;;
use App\Vc\Lib\Engine\Data\MapData;

/**
 * When adding a route ,first this page is displayed in which the route
 * trace can be slected
 *
 */
class SelectTracePage extends XMLResourcePage
{
    private $traces;
    private $next;
    private $id_route;
    
    function __construct($p_traces,$p_next,$p_id_route)
    {
        $this->traces=$p_traces;
        $this->next=$p_next;
        $this->id_route=$p_id_route;
        $this->setResourceFile("trace/SelectTrace.xml");     
        parent::__construct();
    }
    
    
    function makeData(?DataStore $p_parent)
    {
        return new MapData($p_parent,[
            "traces"=>$this->traces
            ,   "route"=>$this->next
            ,   "params"=>["id_route"=>$this->id_route]
        ]);
        
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
    
}