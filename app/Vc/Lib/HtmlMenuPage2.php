<?php
declare(strict_types=1);
namespace App\Vc\Lib;

abstract class HtmlMenuPage2 extends HtmlMenuPage
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