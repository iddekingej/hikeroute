<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Sizer;


use App\Vc\Lib\Widgets\Base\Widget;
use App\Vc\Lib\Engine\Data\DataStore;
use App\Vc\Lib\SubList;

abstract class Sizer extends Widget
{
    use SubList;
    
    function displayItem(Widget $p_widget,DataStore $p_store)
    {
        $l_css="";
        $l_height=$p_widget->getContainerHeight();
        $l_width=$p_widget->getContainerWidth();
        if($l_height){
            $l_css .= "height:$l_height;";
        }
        if($l_width){
            $l_css .= "width:$l_width;";
        }
        $this->theme->base_Sizer->cellHeader($l_css);
        $p_widget->display($p_store);
        $this->theme->base_Sizer->cellFooter();
    }
}