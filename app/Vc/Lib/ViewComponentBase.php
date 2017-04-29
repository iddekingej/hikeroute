<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\ViewComponent;

abstract class ViewComponentBase extends ViewComponent
{
    abstract function display();
}
?>