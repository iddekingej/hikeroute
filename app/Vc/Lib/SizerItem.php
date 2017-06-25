<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * When a item is added to a Sizer, it's wrapped in a SizerItem
 *
 */
class SizerItem extends HtmlComponent
{
       /**
        * Width of space in which the element is placed (it's not the element size)
        * @var unknown
        */
       private $width;
       /**
        * Height of space in which the element is placed (it's not the element size)
        * @var unknown
        */
       
       private $height;
       /**
        * Element that's displayed
        * @var HtmlComponent
        */
       private $element;
       /**
        * Element alignment inside it's available space
        * @var String
        */
       
       private $align=Align::LEFT;
       
       /**
        * Get all js used by element
        * 
        * {@inheritDoc}
        * @see \App\Vc\Lib\HtmlComponent::getJs()
        */

       /**
        * 
        * @param HtmlComponent $p_element element displayed by sizeritem
        */
       function __construct(HtmlComponent $p_element)
       {
           $this->element=$p_element;
           parent::__construct();
       }
       
       
       function getJs():array
       {
           return $this->element->getJs();
       }
       
       /**
        * Get al css used by the element
        * 
        * {@inheritDoc}
        * @see \App\Vc\Lib\HtmlComponent::getCss()
        */
       function getCss():array
       {
           return $this->element->getCss();
       }
    
        /**
         * Display element inside sizer space
         * 
         * {@inheritDoc}
         * @see \App\Vc\Lib\HtmlComponent::display()
         */
       function display():void
       {
           $l_style="";
           if($this->width){
               $l_style .= "width:".$this->theme->e($this->width);
           }
           if($this->height){
               $l_style .= "height:".$this->theme->e($this->height);
           }     
           if($this->align != Align::LEFT){
               $l_style .= "text-align:".$this->align;
           }
           $this->theme->base_Sizer->cellHeader($l_style);
           $this->element->display();
           $this->theme->base_Sizer->cellFooter();
       }
       
       function setAlign(string $p_align)
       {
          $this->align=$p_align;
       }
       
       function getAlign()
       {
           return $this->align;
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