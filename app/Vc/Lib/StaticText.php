<?php
declare(strict_types=1);
namespace App\Vc\Lib;

class StaticText extends HtmlComponent
{
    private $text;
    private $class;
    function __construct($p_text,$p_class="")
    {
        $this->text=$p_text;
        $this->class=$p_class;
        parent::__construct();
    }
    
    function display()
    {
        if($p_class){
            ?><span class="<?=$this->theme->e($p_class)?>"><?=$this->e($this->text)?></span><?php 
        } else {
            echo $this->theme->e($this->text);
        }
            
    }
}