<?php
declare(strict_types=1);
namespace App\Vc\Lib;

class IconTextLink extends HtmlComponent
{
    private $route;
    private $data;
    private $icon;
    private $text;
    
    function __construct(string $p_route,?Array $p_data,string $p_icon,string $p_text)
    {
        $this->route=$p_route;
        $this->data=$p_data;
        $this->icon=$p_icon;
        $this->text=$p_text;
        parent::__construct();
    }
    
    function display()
    {
        $this->theme->imageTextLink(Route($this->route,$this->data),$this->icon,$this->text);
    }
}