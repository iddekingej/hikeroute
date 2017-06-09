<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Base;
abstract class HtmlComponent extends Base
{
    protected $theme;
 
    function __construct()
    {
        $this->theme=new Theme();
    }
    
    function getJs():array
    {
        return [];
    }
    
    function getCss():array
    {
        return [];
    }
    abstract function display();
}