<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\Engine\Data\DataStore;

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
    function displayItems(?DataStore $p_store=null):void
    {
        foreach($this->subItems as $l_item){
            $this->rowHeader();
            $l_item->display($p_store);
            $this->rowFooter();
        }
        
       
    }
}