<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Base;
/**
 * HtmlPage object 
 *
 */
abstract class HtmlPage extends Base
{
    protected $theme;
    protected $title;
    protected $extraCss=[];
    protected $extraJs=[];
    
    function __construct()
    {
        $this->theme=new Theme();
    }
    
    
    /**
     * Display content of page
     */
    
    
    protected abstract function content():void;

    /**
     * Setup page. This is called before the page HTML is produced
     */
    function setup():void
    {
        
    }
    
    /**
     * This is called after the header, but before content
     * This method should contain that product html before the content
     */
    function preContent():void
    {
        
    }
    
    /**
     * Called after the "content"  content (footer).
     */
    function postContent():void
    {
        
    }
    
    /**
     * Display page
     */
    final function display():void
    {
        $this->setup();
        $this->theme->page_Page->pageHeader($this->title,$this->extraJs,$this->extraCss);
        $this->preContent();
        $this->content();
        $this->postContent();
        $this->theme->page_Page->pageFooter();
    }
}