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
        $this->title=__("Album");
        parent::setup();        
    }

    /**
     * Setup menu above the album
     * {@inheritDoc}
     * @see \App\Vc\Route\DisplayPage2::setupTopMenu()
     */
    
    function setupTopMenu():void
    {
        $this->topMenu->addMenuItem("images.add",["id"=>$this->route->id], __("Add image"));
        $this->topMenu->addMenuItem("images.edit",["id"=>$this->route->id], __("Edit album"));
    }
    /**
     * Display Album, this is done by the @see Album object 
     * 
     * {@inheritDoc}
     * @see \App\Vc\Route\DisplayPage2::setupContent()
     */
    function setupContent():void
    {
        parent::setupContent();
        $l_album=new Album($this->route);
        $this->top->add($l_album,"","100%");        
    }
}