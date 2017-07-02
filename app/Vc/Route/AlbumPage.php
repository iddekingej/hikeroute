<?php 
declare(strict_types=1);
namespace App\Vc\Route;

use App\Models\Route;
use App\Vc\Lib\TopMenu;

class AlbumPage extends DisplayPage2
{
    function setup():void
    {
        $this->currentCode="album";        
        parent::setup();        
    }

    function setupTopMenu():void
    {
        $this->topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));
        $this->topMenu->addMenuItem("images.edit",["id"=>$this->route->id], __("Edit album"));
    }
    
    function setupContent():void
    {
        parent::setupContent();
        $l_album=new Album($this->route);
        $this->top->add($l_album,"","100%");        
    }
}