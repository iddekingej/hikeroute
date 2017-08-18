<?php 



use XMLView\Widgets\Base\Widget;
use XMLView\Engine\Data\DynamicValue;
use XMLView\Engine\Data\DataStore;

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