<?php
declare(strict_types=1);
namespace App\Vc\Lib;


use App\Vc\Lib\Engine\Data\DataStore;

/**
 *  Group of menu items used in LeftMenu
 *  Groups are added to the LeftMenu
 *  Items are added to the MenuGroup 
 */
class MenuGroup extends HtmlComponent
{
    /**
     * Menu group title displayed in the menu
     * @var string
     */
    private $title;
    
    /**
     * Sub items (menu items) in group
     * 
     * @var array
     */
    private $subItems=[];
    
    /**
     * Current selected menu item
     * @var string
     */
    private $currentTag;
    
    /**
     * Setup menu group
     * @param unknown $p_title Title displayed in group
     * @param unknown $p_currentTag Current selected menu item
     */
    function __construct($p_title,$p_currentTag)
    {
        $this->title=$p_title;
        $this->currentTag=$p_currentTag;
        parent::__construct();
    }
    /**
     * Add menu item to group
     * 
     * @param MenuItem $p_item
     */
    function addItem(MenuItem $p_item):void
    {
        $this->subItems[]=$p_item;
    }
    
    /**
     * Add a text menu item to group 
     * 
     * @param unknown $p_tag Unique ID for the menu item 
     * @param unknown $p_text  Menu item title
     * @param unknown $p_route Route of menu item
     */
    function addTextItem($p_tag,$p_text,$p_route):void
    {
        $this->addItem(new TextMenuItem($p_tag,$p_text,$p_route));
    }
    
    /**
     * Add an logout menu item
     * 
     * @param unknown $p_tag
     */
    
    function addLogoutItem($p_tag):void
    {
        $this->addItem(new LogoutMenuItem($p_tag));
    }
    /**
     * Display the menu group
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlComponent::display()
     */
    function display(?DataStore $p_store=null):void
    {
        $this->theme->menu_LeftMenu->menuGroup($this->title);
        foreach($this->subItems as $l_item){
            if($l_item->getTag()==$this->currentTag){
                $this->theme->menu_LeftMenu->selectedMenu();
            }
            $l_item->display();
            if($l_item->getTag()==$this->currentTag){
                $this->theme->menu_LeftMenu->selectedMenuFooter();
            }
        }
    }
}