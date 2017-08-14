<?php 
declare(strict_types=1);
namespace App\Vc\Form;

use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Class representing a Textarea form element 
 * 
 */

class FormTextArea extends FormInputElement
{
    /**
     * Width of the textarea in css units
     * @var string
     */
    private $width='100%';
    /**
     * Height of the textarea in css units
     * 
     * @var string
     */
    private $height='100px';
    
    /**
     * Set the width of the text area.
     * 
     * @param string $p_width Width of the text area in pixels.
     */
    
    function setWidth(string $p_width):void
    {
        $this->width=$p_width;
    }
    
    /**
     * Get the width of the text area
     * 
     * @return string Width of the textarea in pixels.
     */
    function getWidth():string
    {
        return $this->width;
    }
    
    /**
     * Set the height of the text area
     * 
     * @param string $p_height height of the text area in pixels. 
     */
    
    function setHeight(string $p_height):void
    {
        $this->height=$p_height;
    }
    /**
     * Get the height of the text area 
     * 
     * @return string Height of the text area in pixels
     */
    function getHeight():string
    {
        return $this->height;
    }
    
    /**
     * Display a textarea element
     * 
     * @see \App\Vc\Form\FormInputElement::displayElement()
     */
    function displayElement(?DataStore $p_store=null):void
    {
        $l_css  ="width:".$this->width.";";
        $l_css .="height:".$this->height;
        $this->theme->base_Form->textAreaElement($this->getId(),$this->getName(),$this->getValue(),$l_css);
    }
}