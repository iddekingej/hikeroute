<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class PageMenu extends HtmlComponent
{
    private $items;
    private $code;
    function addItem($p_code,$p_url,$p_description):void
    {
        $this->items[$p_code]=[$p_url,$p_description];
    }
    
    function addRouteItem($p_code,$p_route,Array $p_parameters,$p_description):void
    {
        $this->addItem($p_code,Route($p_route,$p_parameters),$p_description);
    }
    
    function setCode(?string $p_code):void
    {
        $this->code=$p_code;
    }
    
    function display()
    {
        $this->theme->menu_PageMenu->menuHeader();
        foreach($this->items as $l_code=>$l_item){
            if($l_code===$this->code){
                $this->theme->menu_PageMenu->menuItemSelected($l_item[0],$l_item[1]);
            } else {
                $this->theme->menu_PageMenu->menuItem($l_item[0],$l_item[1]);
            }            
        }
        $this->theme->menu_PageMenu->menuFooter();
    }
}