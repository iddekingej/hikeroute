<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Page;

class TopMenu extends ViewComponentBase
{
    private $items=[];
    function addMenuItem($p_route,Array $p_params,$p_description,$p_icon="")
    {
        $this->items[]=[$p_route,$p_params,$p_description,$p_icon,false];
    }
    
    function addConfirmMenuitem($p_route,Array $p_params,$p_description,$p_confirmMessage,$p_icon="")
    {
        $this->items[]=[$p_route,$p_params,$p_description,$p_icon,true,$p_confirmMessage];
    }
    function display()
    {
        if($this->items){
            Page::topMenuHeader();
            foreach ($this->items as $l_item) {
                if ($l_item[4]) {
                    Page::topMenuItemConfirm($l_item[0], $l_item[1], $l_item[2],$l_item[3], $l_item[5]);
                } else {
                    Page::topMenuItem($l_item[0], $l_item[1], $l_item[2],$l_item[3]);
                }
            }
            Page::topMenuFooter();
        }
    }
}