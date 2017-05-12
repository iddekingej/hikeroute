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
        if($this->route->canEdit(\Auth::user())){
            $l_topMenu=new TopMenu();
            $l_topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));
            $l_topMenu->addMenuItem("images.edit",["id"=>$this->route->id], __("Edit album"));
            $l_topMenu->display();
        }
        $l_album=new Album($this->route);
        $l_album->display();
    }
}