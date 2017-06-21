<?php
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\HtmlMenuPage;
use App\Vc\Lib\TopMenu;
use App\Lib\Icons;

class AllUserPage extends HtmlMenuPage
{
    function setup():void
    {
        $this->setCurrentTag("useradmin");
        parent::setup();
    }
    function content():void
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("admin.users.new", [], __("Add new user"),Icons::ADDUSER);
        $l_topMenu->display();
        $l_list=new AllUserTable();
        $l_list->display();
    }
}