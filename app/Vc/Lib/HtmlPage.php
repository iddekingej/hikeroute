<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Lib\Base;

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
    
    protected abstract function content();

    function setup()
    {
        
    }
    
    function preContent()
    {
        
    }
    
    function postContent()
    {
        
    }
    
    final function display()
    {
        $this->setup();
        $this->theme->page_Page->pageHeader($this->title,$this->extraJs,$this->extraCss);
        $this->preContent();
        $this->content();
        $this->postContent();
        $this->theme->page_Page->pageFooter();
    }
}