<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Engine\Data;


class DynamicVarValue implements DynamicValue
{
    private $var;
    
    function __construct($p_var)
    {
        $this->var=$p_var;
    }
    
    function getValue(DataStore $p_dataStore)
    {
        return $p_dataStore->getValue($this->var);
    }
}