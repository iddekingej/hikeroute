<?php
declare(strict_types=1);
namespace App\Vc\Lib\Engine\Data;

class DataNotFoundException extends \Exception
{
    function __construct($p_name)
    {
        parent::__construct(__("':name' not found in data store ",["name"=>$p_name]));
    }
}