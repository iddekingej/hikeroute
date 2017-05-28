<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class VerticalSizer extends Sizer
{
    function displayItems()
    {
        $this->rowHeader();        
        foreach($this->subItems as $l_item){
            $l_item->display();
        }
        $this->rowFooter();
    }
}