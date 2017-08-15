<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Text;

use App\Vc\Lib\Widgets\Base\Widget;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\DynamicValue;
/**
 * Displays a note message
 *
 */
class Note extends Widget{
    
    /**
     * Text displayed in the note.
     * 
     * @var DynamicValue|null
     */
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
     * Get text of the note
     * 
     * @return DynamicValue
     */
    function getText():?DynamicValue
    {
        return $this->text;
    }
    
    function displayContent(?DataStore $p_store)
    {
        if($this->text != null){
            $this->theme->page_Page->note($this->text->getValue($p_store));
        }
    }
}