<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use XMLView\Engine\Data\DataStore;;

/**
 * HtmlMenuPage with pure VC components
 * 
 *
 */
abstract class HtmlMenuPage2 extends HtmlPage
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
     * This is the top most element. All page lement must be added to this sizer
     * 
     * @var VerticalSizer
     */
    protected $top;
    
    abstract function setupContent();
    
    /**
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlMenuPage::setup()
     */
    function setup():void
    {
        parent::setup();
        
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
        $this->top=new VerticalSizer();
        $this->setupContent();
        $l_js=$this->top->getJs();
        if($l_js !== null){
            $this->extraJs =array_merge($this->extraJs,$l_js);
        }
        $l_css=$this->top->getCss();
        if($l_css !== null){
            $this->extraCss=array_merge($this->extraCss,$l_css);
        }
    }
    
    /**
     * Display all compontents
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::content()
     */
    final function content(?DataStore $p_store=null):void
    {
        $this->top->display($p_store);
    }
    
    function preContent(?DataStore $p_store=null):void
    {
        $this->theme->page_MenuPage->MenuHeader();
        $this->leftMenu->display();
        parent::preContent();
        $this->theme->page_MenuPage->contentSection();
    }
    
    function postContent(?DataStore $p_store=null):void
    {
        parent::postContent();
        $this->theme->page_MenuPage->menuPageFooter();
    }
}