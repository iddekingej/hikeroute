<?php
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class HtmlPage2 extends HtmlPage
{
    protected $top;
    abstract function setupContent();
    
    
    function setup()
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
    final function content()
    {
        $this->top->display();
    }
}