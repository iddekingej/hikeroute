<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\HtmlComponent;

class VLayout extends HtmlComponent
{
    private $items=[];
    
    function addItem(HtmlComponent $p_item):void
    {
        $this->items[]=$p_item;
    }
    
    function display():void
    {
        $this->theme->base_VLayout->header();
        foreach($this->items as $l_item){
            $this->theme->base_VLayout->itemHeader();
            $l_item->display();
            $this->theme->base_VLayout->itemFooter();
        }
        $this->theme->base_VLayout->footer();
           
    }
}