<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * Horizontal sizer.
 * Orient all sub elements horizontally
 * @See App\Vc\Lib\Sizer
 */
class VerticalSizer extends Sizer
{
    /**
     * Displayer sizer subitems
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\Sizer::displayItems()
     */
    function displayItems():void
    {
        $this->rowHeader();        
        foreach($this->subItems as $l_item){
            $l_item->display();
        }
        $this->rowFooter();
    }
}