<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use XMLView\Engine\Data\DataStore;;

/**
 * 'LeftMenu' class. Displays a vertical menu 
 *
 */
class LeftMenu extends HtmlComponent
{
    /**
     * Array with menu elements of MenuGroup
     * 
     * @var array
     */
    private $leftMenu=[];
    /**
     * Current selected menu item
     * @var unknown
     */
    private $currentTag;
    
    /**
     * Adds a MenuGroup to the menu. Menu items are added to the MenuGroup 
     * @param unknown $p_title
     * @return MenuGroup
     */
    function addMenuGroup(string $p_title):MenuGroup
    {
        $l_menuGroup=new MenuGroup($p_title,$this->currentTag);
        $this->leftMenu[]=$l_menuGroup;
        return $l_menuGroup;
    }
    
    /**
     * Set the "CurrentTag'. The menu element with this tag is higlighted to indicate the current selected
     * menu item
     * @param unknown $p_currentTag
     */
    
    function setCurrentTag($p_currentTag):void
    {
        $this->currentTag=$p_currentTag;
    }
    
    /**
     * Displays the menu
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null):void
    {
        foreach($this->leftMenu as $l_group){
            $l_group->display();
        }
    }
}