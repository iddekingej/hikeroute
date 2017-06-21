<?php
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * Page with a menu on the left side
 * 
 */
abstract class HtmlMenuPage extends HtmlPage
{
    /**
     * Left menu object
     * 
     * @var LeftMenu
     */
    private $leftMenu;
    
    function __construct()
    {
        $this->leftMenu=new LeftMenu();
        parent::__construct();
    }
    /**
     * Set current tag=which menu item is selected
     * 
     * @param unknown $p_currentTag
     */
    function setCurrentTag($p_currentTag):void
    {
        $this->leftMenu->setCurrentTag($p_currentTag);
    }
    
    /**
     * Set default menu items
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::setup()
     */
    function setup():void
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
    
    function preContent():void
    {
        $this->theme->page_MenuPage->MenuHeader();
        $this->leftMenu->display();
        parent::preContent();
        $this->theme->page_MenuPage->contentSection();
    }
    
    function postContent():void
    {
        parent::postContent();
        $this->theme->page_MenuPage->menuPageFooter();
    }
}