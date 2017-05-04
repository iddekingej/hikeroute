<?php
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\MenuItem;
use App\Lib\Page;



class TextMenuItem extends MenuItem
{
    private $text;
    private $route;
    
    function __construct($p_tag,$p_text,$p_route)
    {
        $this->text=$p_text;
        $this->route=$p_route;
        parent::__construct($p_tag);
    }
    
    function display()
    {
        Page::menuItem($this->route,$this->text);
    }
}