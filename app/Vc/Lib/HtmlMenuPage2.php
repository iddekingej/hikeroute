<?php
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * HtmlMenuPage with pure VC components
 * 
 *
 */
abstract class HtmlMenuPage2 extends HtmlMenuPage
{
    /**
     * This is the top most element. All page lement must be added to this sizer
     * 
     * @var VerticalSizer
     */
    protected $top;
    
    abstract function setupContent();
    
    /**
     * 
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlMenuPage::setup()
     */
    function setup():void
    {
        parent::setup();
        $this->top=new VerticalSizer();
        $this->setupContent();
        $l_js=$this->top->getJs();
        if($l_js !== null){
            $this->extraJs =array_merge($this->extraJs,$l_js);
        }
        $l_css=$this->top->getCss();
        if($l_css !== null){
            $this->extraCss=array_merge($this->extraCss,$l_css);
        }
    }
    
    /**
     * Display all compontents
     * {@inheritDoc}
     * @see \App\Vc\Lib\HtmlPage::content()
     */
    final function content():void
    {
        $this->top->display();
    }
    
}