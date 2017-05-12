<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\HtmlComponent;

class YesNoLink extends HtmlComponent
{
    private $route;
    private $data;
    private $text;
    private $value;
    
    function __construct(string $p_route,?Array $p_data,string $p_text,int $p_value)
    {
        $this->route=$p_route;
        $this->data=$p_data;
        $this->text=$p_text;
        $this->value=$p_value;
        parent::__construct();
    }
    
    function display():void
    {
        $this->theme->yesNoLink($this->text,$this->route,$this->data,$this->value);
    }
}