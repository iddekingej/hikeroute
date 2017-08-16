<?php
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Lists;

use App\Vc\Lib\Engine\Data\DynamicValue;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\Theme;

class InfoTableText extends InfoTableItem
{
    private $text;
    
    function setText(DynamicValue $p_text):void
    {
        $this->text=$p_text;
    }
    
    function getText():?DynamicValue
    {
        return $this->text;
    }
    
    function displayValue(DataStore $p_store):void
    {
        $l_text=$this->getAttValue("text", $p_store);
        echo $this->theme->e($l_text);
    }
}