<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Page;

abstract class HtmlMenuPage extends HtmlPage
{
    function preContent()
    {
        $this->theme->menu_LeftMenu->MenuHeader();
        Page::menuGroup(__("Profile"));
        $this->theme->menu_LeftMenu->logoutMenu();
        Page::menuItem("user.profile", __("Profile"));
        if (\Auth::user() && \Auth::user()->isAdmin()) {
            Page::menuGroup(__("Administration"));
            Page::menuItem("admin.users", __("Users"));
        }
        Page::menuGroup(__("Routes"));
        Page::menuItem("traces.list", __("Route traces"));
        Page::menuItem("routes", __("Routes"));
        Page::menuItem("start", __("Published routes"));
        parent::preContent();
        $this->theme->menu_LeftMenu->contentSection();
    }
    
    function postContent()
    {
        parent::postContent();
        $this->theme->menu_LeftMenu->menuPageFooter();
    }
}