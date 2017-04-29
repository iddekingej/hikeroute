<?php 
declare(strict_types=1);
namespace App\Vc\Lib;


abstract class HtmlComponent
{
    protected $theme;
 
    function __construct()
    {
        $this->theme=new Theme();
    }
    
    abstract function display();
}