<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Page;

abstract class HtmlMenuPage extends HtmlPage
{
    private $leftMenu=[];
    protected $currentTag;
    
    function addMenuGroup($p_title):MenuGroup
    {
        $l_menuGroup=new MenuGroup($p_title,$this->currentTag);
        $this->leftMenu[]=$l_menuGroup;
        return $l_menuGroup;
    }
    
    function setup()
    {
        if(\Auth::check()){
            $l_group=$this->addMenuGroup(__("Profile"));
        
            $l_group->addLogoutItem("logout");
            $l_group->addTextItem("profile", __("Profile"),"user.profile");
        }
        if (\Auth::user() && \Auth::user()->isAdmin()) {
            $l_group=$this->addMenuGroup(__("Administration"));
            $l_group->addTextItem("useradmin", __("Users"),"admin.users");
        }
        $l_group=$this->addMenuGroup(__("Routes"));
        if(\Auth::check()){
            $l_group->addTextItem("traces",__("Route traces"),"traces.list");
            $l_group->addTextItem("routes",__("Routes"),"routes");
        }
        $l_group->addTextItem("start",__("Published routes"),"start");
    }
    function preContent()
    {
        $this->theme->menu_LeftMenu->MenuHeader();
        foreach($this->leftMenu as $l_group){
            $l_group->display();
        }
        parent::preContent();
        $this->theme->menu_LeftMenu->contentSection();
    }
    
    function postContent()
    {
        parent::postContent();
        $this->theme->menu_LeftMenu->menuPageFooter();
    }
}