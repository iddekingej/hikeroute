<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class Spacer extends HtmlComponent{
    private $direction;
    const VERTICAL=0;
    const HORIZONTAL=1;
    
    function __construct($p_direction)
    {
        $this->direction=$p_direction;
        parent::__construct();
    }
    
    function display()
    {
        if($this->direction==static::VERTICAL){
            ?><div style='position:relative;width:0px;height:100%'>&nbsp;</div><?php 
        } else {
            ?><div style='position:relative;width:100%;height:0px'>&nbsp;</div><?php
        }
    }
}
?>