<?php
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class HtmlPage2 extends HtmlPage
{
    protected $top;
    abstract function setupContent();
    
    final function content()
    {
        $this->top=new VerticalSizer();
        $this->setupContent();
        $this->top->display();
    }
}