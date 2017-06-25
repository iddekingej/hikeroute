<?php
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\MenuItem;

/**
 * MenuItem for LeftMenu
 * This menu item is displayed as a text link.
 *
 */
class TextMenuItem extends MenuItem
{
    /**
     * Text displayed in menu item
     * @var unknown
     */
    private $text;
    private $route;
    private $params;
    
    function __construct(String $p_tag,String $p_text,String $p_route,Array $p_params=[])
    {
        $this->text=$p_text;
        $this->route=$p_route;
        $this->params=$p_params;
        parent::__construct($p_tag);
    }
    
    function display():void
    {
        $this->theme->menu_LeftMenu->menuItem($this->route,$this->params,$this->text);
    }
}