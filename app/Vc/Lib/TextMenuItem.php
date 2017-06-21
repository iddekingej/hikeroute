<?php
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\MenuItem;



class TextMenuItem extends MenuItem
{
    private $text;
    private $route;
    
    function __construct(String $p_tag,String $p_text,String $p_route)
    {
        $this->text=$p_text;
        $this->route=$p_route;
        parent::__construct($p_tag);
    }
    
    function display():void
    {
        $this->theme->menu_LeftMenu->menuItem($this->route,$this->text);
    }
}