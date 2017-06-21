<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Vc\Lib\TopMenu;

class AlbumPage extends DisplayPage
{
    function setup():void
    {
        parent::setup();        
        $this->currentCode="album";
    }

    function setupTopMenu():void
    {
        $this->topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));
        $this->topMenu->addMenuItem("images.edit",["id"=>$this->route->id], __("Edit album"));
    }
    
    function content():void
    {
        $l_album=new Album($this->route);
        $l_album->display();
    }
}