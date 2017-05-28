<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class Sizer extends HtmlComponent
{
    protected $subItems=[];
    
    function add(HtmlComponent $p_component,$p_width="",$p_height=""){
        $l_component=new SizerItem($p_component);
        $l_component->setWidth($p_width);
        $l_component->setHeight($p_height);
        $this->subItems[]=$l_component;
        return $l_component;
    }
    
    
    protected function rowHeader()
    {
        $this->theme->base_Sizer->rowHeader();
    }
    
    protected function rowFooter()
    {
        $this->theme->base_Sizer->rowFooter();
    }
    
    abstract function displayItems();
    
    function display()
    {
        $this->theme->base_Sizer->sizerHeader();
        $this->displayItems();
        $this->theme->base_Sizer->sizerFooter();
    }
}