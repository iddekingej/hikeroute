<?php 

use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\DynamicValue;
use App\Vc\Lib\Widgets\Base\Widget;

class TestComponent extends Widget
{
    private $text;
    
    function setText(DynamicValue $p_text)
    {
        $this->text=$p_text;
    }
    
    function getText()
    {
        return $this->text;
    }
    
    function displayContent(?DataStore $p_store=null)
    {
        echo $this->text->getValue($p_store);
    }
}