<?php 

namespace App\Vc\Lib\Widgets\Base;

use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\VerticalSizer;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Widgets\Base\Widget;


/**
 * Top container used for XML Resources
 *
 */
class GUIFragment extends Widget{
    
    private $top;
    
    /**
     * Set up default size of all sub widget
     */
    function __construct()
    {
        parent::__construct();
        $this->top=new VerticalSizer();
    }
    
    /**
     * Add child widget
     *      
     * @return \App\Vc\Lib\HtmlComponent child widge
     */
    function add(HtmlComponent $p_child){
        $this->top->add($p_child);
        $p_child->setParent($this);
        return $p_child;
    }
    
    /**
     * Display all content 
     */
    function displayContent(?DataStore $p_store=null)
    {
        $this->top->display($p_store);
    }
}