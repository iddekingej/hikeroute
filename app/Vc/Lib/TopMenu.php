<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * 
 * Another horizontal menu 
 *
 */

class TopMenu extends HtmlComponent
{
    /**
     * Menu items
     * @var array
     */
    
    private $items=[];
    
    /**
     * Add menu item
     * @param string $p_route      Route of menu
     * @param array $p_params      Route parameters
     * @param string $p_description Text displayed in menu
     * @param string $p_icon        Icon displayed in menu
     */
    function addMenuItem(string $p_route,Array $p_params,string $p_description,string $p_icon=""):void
    {
        $this->items[]=[$p_route,$p_params,$p_description,$p_icon,false];
    }
    
    /**
     * Add menu item with confirmation
     * 
     * @param unknown $p_route           Route of menu item
     * @param array $p_params            Route parameter
     * @param unknown $p_description     Menu item title
     * @param unknown $p_confirmMessage  Confirmation text
     * @param string $p_icon             Menu item icon
     */
    function addConfirmMenuitem($p_route,Array $p_params,$p_description,$p_confirmMessage,$p_icon=""):void
    {
        $this->items[]=[$p_route,$p_params,$p_description,$p_icon,true,$p_confirmMessage];
    }
    
    /**
     * Display menu 
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display():void
    {
        if($this->items){
            $this->theme->menu_TopMenu->topMenuHeader();
            foreach ($this->items as $l_item) {
                if ($l_item[4]) {
                    $this->theme->menu_TopMenu->topMenuItemConfirm($l_item[0], $l_item[1], $l_item[2],$l_item[3], $l_item[5]);
                } else {
                    $this->theme->menu_TopMenu->topMenuItem($l_item[0], $l_item[1], $l_item[2],$l_item[3]);
                }
            }
            $this->theme->menu_TopMenu->topMenuFooter();
        }
    }
}