<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Engine\Parser;

use App\Vc\Lib\Engine\XMLStatementWriter;

abstract class Node
{
    abstract function compile(XMLStatementWriter $p_writer):void;
}