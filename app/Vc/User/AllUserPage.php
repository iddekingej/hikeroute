<?php
declare(strict_types=1);
namespace App\Vc\User;

use App\Vc\Lib\TopMenu;
use App\Lib\Icons;
use App\Vc\Lib\HtmlMenuPage2;
/** 
 * Page for display all users for administration.
 * This page contains the AllUserTable table. 
 *
 */
class AllUserPage extends HtmlMenuPage2
{
    function setup():void
    {
        $this->setCurrentTag("useradmin");
        parent::setup();
    }
    
    /**
     * Prints the user page. This page contrains a menu and a list of all users
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::content()
     */
    function setupContent():void
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("admin.users.new", [], __("Add new user"),Icons::ADDUSER);
        $this->top->add($l_topMenu,"100%","0px");
        $l_list=new AllUserTable();
        $this->top->add($l_list);        
    }
}