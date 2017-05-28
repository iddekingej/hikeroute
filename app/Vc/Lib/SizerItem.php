<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class SizerItem extends HtmlComponent
{
       private $width;
       private $height;
       private $element;
       function __construct(HtmlComponent $p_element)
       {
           $this->element=$p_element;
           parent::__construct();
       }
       
       function display()
       {
           $l_style="";
           if($this->width){
               $l_style .= "width:".$this->theme->e($this->width);
           }
           if($this->height){
               $l_style .= "height:".$this->theme->e($this->height);
           }
           $this->theme->base_Sizer->cellHeader($l_style);
           $this->element->display();
           $this->theme->base_Sizer->cellFooter();
       }
       function getWidth()
       {
           return $this->width;
       }
       
       function getHeight()
       {
           return $this->height;
       }
       
       function setWidth($p_width)
       {
           $this->width=$p_width;
       }
       
       function setHeight($p_height)
       {
           $this->height=$p_height;
       }
}