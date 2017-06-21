<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\HtmlComponent;

class TextRouteLink extends HtmlComponent
{
    private $route;
    private $data;
    private $text;
    
    function __construct(string $p_route,?Array $p_data,string $p_text)
    {
        $this->route=$p_route;
        $this->data=$p_data;
        $this->text=$p_text;
        parent::__construct();
    }
    
    function display():void
    {
        $this->theme->textRouteLink($this->route,$this->data,$this->text);
    }
}