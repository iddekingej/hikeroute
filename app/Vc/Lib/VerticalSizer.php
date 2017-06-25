<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * Orient elements horizontaly on page
 *
 */
class VerticalSizer extends Sizer
{
    /**
     * Display all subitems
     *   
     * {@inheritDoc}
     * @see \App\Vc\Lib\Sizer::displayItems()
     */
    function displayItems():void
    {
        foreach($this->subItems as $l_item){
            $this->rowHeader();
            $l_item->display();
            $this->rowFooter();
        }
        
       
    }
}