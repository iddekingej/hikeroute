<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\DynamicValue;
/**
 * Displays a note message
 *
 */
class Note extends HtmlComponent{
    
    private $text;
    

    /**
     * Set the text of the node 
     * @param DynamicValue $p_text    
     */
    function setText(DynamicValue $p_text):void
    {
        $this->text=$p_text;
    }
    
    /**
     * Get text of the not 
     * 
     * @return string
     */
    function getText():DynamicValue
    {
        return $this->text;
    }
    
    function display(?DataStore $p_store=null):void
    {
        $this->theme->page_Page->note($this->text->getValue($p_store));        
    }
}