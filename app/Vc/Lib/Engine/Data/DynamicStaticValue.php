<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Engine\Data;

class DynamicStaticValue implements DynamicValue
{
    private $value;
    
    function __construct($p_value)
    {
        $this->value=$p_value;
    }
    
    function getValue(DataStore $p_store)
    {
        return $this->value;
    }
}