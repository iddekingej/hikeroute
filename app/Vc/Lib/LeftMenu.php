<?php
declare(strict_types=1);
namespace App\Vc\Lib;

class LeftMenu extends HtmlComponent
{
    private $leftMenu=[];
    private $currentTag;
    
    function addMenuGroup($p_title):MenuGroup
    {
        $l_menuGroup=new MenuGroup($p_title,$this->currentTag);
        $this->leftMenu[]=$l_menuGroup;
        return $l_menuGroup;
    }
    
    function setCurrentTag($p_currentTag)
    {
        $this->currentTag=$p_currentTag;
    }
    
    function display()
    {
        foreach($this->leftMenu as $l_group){
            $l_group->display();
        }
    }
}