<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use XMLView\Engine\Data\DataStore;;

/**
 * A spacer adds a empty space in a gui that is as big as possible
 *
 */
class Spacer extends HtmlComponent{
    private $direction;
    const VERTICAL=0;
    const HORIZONTAL=1;
    
    function __construct(int $p_direction=Spacer::VERTICAL)
    {
        $this->direction=$p_direction;
        parent::__construct();
    }
    
    /**
     * A spaces fills the remaining space with an empty space.
     * Spacer::VERTICAL fills the space horizontal
     * Spaces::HORIZONTAL fill the space vertical
     * 
     * @param int $p_direction Value Spacer::VERTICAl or Space::HORIZONTAL for vertical or horizontal direction
     */
    function setDirection(int $p_direction):void
    {
        $this->direction=$p_direction;
    }
    
    /**
     * Get direction of spacer.
     * 
     * @return int
     */
    
    function getDirection():int
    {
        return $this->direction;
    }
    
    /**
     * Display the spacer
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null)
    {
        if($this->direction==static::VERTICAL){
            ?><div style='position:relative;width:0px;height:100%'>&nbsp;</div><?php 
        } else {
            ?><div style='position:relative;width:100%;height:0px'>&nbsp;</div><?php
        }
    }
}
?>