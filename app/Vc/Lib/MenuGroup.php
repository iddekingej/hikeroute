<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Page;

class MenuGroup extends HtmlComponent
{
    private $title;
    private $subItems=[];
    private $currentTag;
    function __construct($p_title,$p_currentTag)
    {
        $this->title=$p_title;
        $this->currentTag=$p_currentTag;
        parent::__construct();
    }
    
    function addItem(MenuItem $p_item):void
    {
        $this->subItems[]=$p_item;
    }
    
    function addTextItem($p_tag,$p_text,$p_route):void
    {
        $this->addItem(new TextMenuItem($p_tag,$p_text,$p_route));
    }
    
    function addLogoutItem($p_tag)
    {
        $this->addItem(new LogoutMenuItem($p_tag));
    }
    
    function display()
    {
        Page::menuGroup($this->title);
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