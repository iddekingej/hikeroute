<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class VerticalSizer extends Sizer
{
    function displayItems():void
    {
        foreach($this->subItems as $l_item){
            $this->rowHeader();
            $l_item->display();
            $this->rowFooter();
        }
        
       
    }
}