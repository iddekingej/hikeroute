<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Vc\Lib\TopMenu;

class AlbumPage extends DisplayPage
{
    function setup()
    {
        $this->currentCode="album";
        parent::setup();
    }
      
    function content()
    {
        $l_topMenu=new TopMenu();
        $l_topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));
        $l_topMenu->display();
        $l_album=new Album($this->route);
        $l_album->display();
    }
}