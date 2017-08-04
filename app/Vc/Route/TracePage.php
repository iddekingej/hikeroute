<?php 
declare(strict_types=1);
namespace App\Vc\Route;
use App\Vc\Trace\OpenLayer;
use App\Vc\Lib\TopMenu;
/**
 * This page part of the route information pages.
 * This page prints a map with the GPX route on it 
 *
 */
class TracePage extends DisplayPage
{
    /**
     * Setup form
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlMenuPage2::setup()
     */
    function setup():void
    {
        $this->currentCode="trace";
        parent::setup();
    }

    /**
     * Setup menu on top of the page
     * 
     * {@inheritDoc}
     * @see \App\Vc\Route\DisplayPage::setupTopMenu()
     */
    
    function setupTopMenu():void
    {
        $this->topMenu->addMenuitem("routes.trace.edit", ["id"=>$this->route->id],  __("Upload new gpx file"));
    }
    
    /**
     * Setup content 
     * 
     * {@inheritDoc}
     * @see \App\Vc\Route\DisplayPage::setupContent()
     */
    function setupContent():void
    {
        parent::setupContent();
        $this->top->add(new OpenLayer($this->route->routeTrace),"100%","100%");        
    }
}