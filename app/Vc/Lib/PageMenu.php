<?php 
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Horizontal menu
 * @author jeroen
 *
 */
class PageMenu extends HtmlComponent
{
    private $items;
    private $code;
    
    /**
     * Add menu item to menu 
     * 
     * @param unknown $p_code unique ID of menu item
     * @param unknown $p_url  Url used when clicking to menu item
     * @param unknown $p_description Text displayed in menu
     */
    function addItem($p_code,$p_url,$p_description):void
    {
        $this->items[$p_code]=[$p_url,$p_description];
    }
    
    /**
     * Add menu item add menu. Same ass addItem but URL is given as a route
     * 
     * @param unknown $p_code  unique ID of menu item
     * @param unknown $p_route Route
     * @param array $p_parameters Route parameters
     * @param unknown $p_description Text displayed in menu item
     */
    function addRouteItem($p_code,$p_route,Array $p_parameters,$p_description):void
    {
        $this->addItem($p_code,Route($p_route,$p_parameters),$p_description);
    }
    
    /**
     * Set current menu item. This is used for highliging the current menu item.
     * @param string $p_code
     */
    function setCode(?string $p_code):void
    {
        $this->code=$p_code;
    }
    
    /**
     * Display menu 
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null):void
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