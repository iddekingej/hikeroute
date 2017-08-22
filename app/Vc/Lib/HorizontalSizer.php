<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use XMLView\Engine\Data\DataStore;;

/**
 * Horizontal sizer.
 * Orient all sub elements horizontally
 * @See App\Vc\Lib\Sizer
 */
class HorizontalSizer extends Sizer
{
    /**
     * Displayer sizer subitems
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\Sizer::displayItems()
     */
    function displayItems(?DataStore $p_store=null):void
    {
        $this->rowHeader();        
        foreach($this->subItems as $l_item){
            $l_item->display();
        }
        $this->rowFooter();
    }
}