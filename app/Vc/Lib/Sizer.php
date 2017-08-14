<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\Engine\Data\DataStore;

/**
 * A sizer determines how elements are placed on a page 
 * There is for example a vertical sizer that places elements vertically or a horizontal size that 
 * places all element horizontal.
 * This is a base class of a sizer
 */
abstract class Sizer extends HtmlComponent
{
    use SubItems;
    
    /**
     * Prints the header before each item
     */
    protected function rowHeader():void
    {
        $this->theme->base_Sizer->rowHeader();
    }

    /**
     * Prints the footer after each item
     */
    protected function rowFooter():void
    {
        $this->theme->base_Sizer->rowFooter();
    }
    
    /**
     * Displays each child element
     */
    abstract function displayItems(?DataStore $p_store=null):void;
    
    /**
     * Displays the sizer.
     * The elements are printed as follows
     * 
     * Header
     * {LOOP:
     *      rowHeader
     *        Item
     *      rowFooter
     *}
     *Footer
     */
    function display(?DataStore $p_store=null):void
    {
        $this->theme->base_Sizer->sizerHeader();
        $this->displayItems($p_store);
        $this->theme->base_Sizer->sizerFooter();
    }
}