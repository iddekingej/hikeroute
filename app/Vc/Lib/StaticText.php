<?php
declare(strict_types=1);
namespace App\Vc\Lib;

class StaticText extends HtmlComponent
{
    private $text;
    private $class;
    function __construct($p_text,string $p_class="")
    {
        $this->text=$p_text;
        $this->class=$p_class;
        parent::__construct();
    }
    
    function display():void
    {
        if($this->class){
            ?><span class="<?=$this->theme->e($this->class)?>"><?=$this->theme->e($this->text)?></span><?php 
        } else {
            echo $this->theme->e($this->text);
        }
            
    }
}