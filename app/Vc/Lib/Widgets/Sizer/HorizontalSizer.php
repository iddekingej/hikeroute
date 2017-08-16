<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Sizer;


use App\Vc\Lib\Engine\Data\DataStore;

class HorizontalSizer extends Sizer
{
    function displayContent(?DataStore $p_store)
    {
        $this->theme->base_Sizer->sizerHeader();
        $this->theme->base_Sizer->rowHeader();
        foreach($this->subItems as $l_item){
            $this->displayItem($l_item, $p_store);
        }
        $this->theme->base_Sizer->rowFooter();
        $this->theme->base_Sizer->sizerFooter();
    }
}