<?php
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class HtmlMenuPage extends HtmlPage
{
    private $leftMenu;
    
    function __construct()
    {
        $this->leftMenu=new LeftMenu();
        parent::__construct();
    }
    
    function setCurrentTag($p_currentTag):void
    {
        $this->leftMenu->setCurrentTag($p_currentTag);
    }
    
    function setup()
    {

        if(\Auth::check()){
            $l_group=$this->leftMenu->addMenuGroup(__("Profile"));
        
            $l_group->addLogoutItem("logout");
            $l_group->addTextItem("profile", __("Profile"),"user.profile");
        }
        if (\Auth::user() && \Auth::user()->isAdmin()) {
            $l_group=$this->leftMenu->addMenuGroup(__("Administration"));
            $l_group->addTextItem("useradmin", __("Users"),"admin.users");
        }
        $l_group=$this->leftMenu->addMenuGroup(__("Routes"));
        if(\Auth::check()){
            $l_group->addTextItem("traces",__("Route traces"),"traces.list");
            $l_group->addTextItem("routes",__("Routes"),"routes");
        }
        $l_group->addTextItem("start",__("Published routes"),"start");
    }
    function preContent()
    {
        $this->theme->page_MenuPage->MenuHeader();
        $this->leftMenu->display();
        parent::preContent();
        $this->theme->page_MenuPage->contentSection();
    }
    
    function postContent()
    {
        parent::postContent();
        $this->theme->page_MenuPage->menuPageFooter();
    }
}