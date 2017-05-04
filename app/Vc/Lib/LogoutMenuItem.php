<?php
declare(strict_types=1);
namespace App\Vc\Lib;
use App\Vc\Lib\MenuItem;



class LogoutMenuItem extends MenuItem
{
    function display()
    {
        $this->theme->menu_LeftMenu->logoutMenu();
    }
}