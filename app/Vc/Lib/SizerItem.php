<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\Lib\Engine\Data\DataStore;

/**
 * When a item is added to a Sizer, it's wrapped in a SizerItem
 * TODO: Move properties to HTMLComponent and merge this with Sizer
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
        * 
        * @param HtmlComponent $p_element element displayed by sizeritem
        */
       function __construct(HtmlComponent $p_element)
       {
           $this->element=$p_element;
           
           $this->width=$p_element->getContainerWidth();
           $this->height=$p_element->getContainerHeight();
           $this->align=$p_element->getContainerAlign();
           
           parent::__construct();
       }
       
       /**
        * Get all js used by element
        *
        * {@inheritDoc}
        * @see \App\Vc\Lib\HtmlComponent::getJs()
        */
       
       
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
         * TODO: handle horizontal align
         * {@inheritDoc}
         * @see \App\Vc\Lib\HtmlComponent::display()
         */
       function display(?DataStore $p_store=null):void
       {
           $l_style="vertical-align:top;";
           if($this->width){
               $l_style .= "width:".$this->theme->e($this->width).";";
           }
           if($this->height){
               $l_style .= "height:".$this->theme->e($this->height).";";
           }     
   
           $this->theme->base_Sizer->cellHeader($l_style);            
           $this->element->display($p_store);
          
           $this->theme->base_Sizer->cellFooter();
       }
       
       /**
        * Set horizontal align of element inside its sizer space
        * 
        * @param string $p_align
        */
       function setAlign(string $p_align)
       {
          $this->align=$p_align;
       }
       
       /**
        *  Set horizontal align.
        *  
        * @return string
        */
       
       function getAlign()
       {
           return $this->align;
       }
       
       /**
        * Get Horizontal width (in css unit of size space.
        * 
        * @return string
        */
       
       function getWidth()
       {
           return $this->width;
       }
       
       /**
        * Get height of size space in which the item is placed.
        * 
        * @return string
        */
       
       function getHeight()
       {
           return $this->height;
       }
       
       /**
        * Set width of sizer space in which the element is placed.
        * 
        * @param string  $p_width Width in CSS units.
        * 
        */
       
       function setWidth(string $p_width):void
       {
           $this->width=$p_width;
       }
       
       /**
        * Set height of sizer space in which the element is placed
        * 
        * @param string $p_height Height in CSS units.
        */
       
       function setHeight($p_height):void
       {
           $this->height=$p_height;
       }
}