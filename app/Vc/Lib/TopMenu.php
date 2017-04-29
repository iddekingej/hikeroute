<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Page;

class TopMenu extends ViewComponentBase
{
    private $items=[];
    function addMenuItem($p_route,Array $p_params,$p_description)
    {
        $this->items[]=[$p_route,$p_params,$p_description,false];
    }
    
    function addConfirmMenuitem($p_route,Array $p_params,$p_description,$p_confirmMessage)
    {
        $this->items[]=[$p_route,$p_params,$p_description,true,$p_confirmMessage];
    }
    function display()
    {
        if($this->items){
            Page::topMenuHeader();
            foreach ($this->items as $l_item) {
                if ($l_item[3]) {
                    Page::topMenuItemConfirm($l_item[0], $l_item[1], $l_item[2], $l_item[4]);
                } else {
                    Page::topMenuItem($l_item[0], $l_item[1], $l_item[2]);
                }
            }
            Page::topMenuFooter();
        }
    }
}