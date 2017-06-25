<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class Sizer extends HtmlComponent
{
    protected $subItems=[];
    
    function getJs():array
    {
        $l_js=[];
        foreach($this->subItems as $l_item){
            $l_js=array_merge($l_js,$l_item->getJs());
        }
        return array_unique($l_js);
    }
    
    function getCss():array
    {
        $l_css=[];
        foreach($this->subItems as $l_item){
            $l_css=array_merge($l_css,$l_item->getCss());
        }
        return array_unique($l_css);
    }
    
    function add(HtmlComponent $p_component,$p_width="",$p_height="",String $p_align=Align::LEFT){
        $l_component=new SizerItem($p_component);
        $l_component->setWidth($p_width);
        $l_component->setHeight($p_height);
        $l_component->setAlign($p_align);
        $this->subItems[]=$l_component;
        return $l_component;
    }
    
    
    protected function rowHeader():void
    {
        $this->theme->base_Sizer->rowHeader();
    }
    
    protected function rowFooter():void
    {
        $this->theme->base_Sizer->rowFooter();
    }
    
    abstract function displayItems():void;
    
    function display():void
    {
        $this->theme->base_Sizer->sizerHeader();
        $this->displayItems();
        $this->theme->base_Sizer->sizerFooter();
    }
}