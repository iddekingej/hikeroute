<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class Theme
{
    function __get($p_name)
    {
        $l_name=str_replace("_", "\\", $p_name);
        $l_className="\\App\\Vc\\Theme\\".$l_name;
        $this->$p_name=new $l_className($this);
        return $this->$p_name;
    }
}