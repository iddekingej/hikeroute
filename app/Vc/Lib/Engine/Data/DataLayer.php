<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Engine\Data;

interface DataLayer
{
    function processData(DataStore $p_parent):DataStore;    
}
