<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Engine\Data;

interface DynamicValue
{
    function getValue(DataStore $p_dataStore);
}