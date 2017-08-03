<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class Sizer extends HtmlComponent
{
    use SubItems;
    
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