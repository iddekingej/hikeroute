<?php 

use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Engine\Data\DynamicValue;

class TestComponent extends HtmlComponent
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
    
    function display(?DataStore $p_store=null)
    {
        echo $this->text->getValue($p_store);
    }
}