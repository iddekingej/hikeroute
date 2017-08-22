<?php
declare(strict_types=1);
namespace App\Vc\Lib;

use XMLView\Engine\Data\DataStore;;

/**
 * Displays a static text
 * When class is set, it is displayed in a span element
 *
 */
class StaticText extends HtmlComponent
{
    /**
     * Static text displayed on the page
     * @var string
     */
    
    private $text;
    
    /**
     * CSS class used for the text. When this is set , the text
     * is displayed in a span element.
     * Default value: empty
     * 
     * @var string
     */
    
    private $class="";

    /**
     * Set up object
     * 
     * @param string $p_text    Text displayed as static text. 
     *                          The text is html escaped before it is displayed.
     * @param string $p_class   CSS Class used for displaying the text.(Default no class)
    */

    function __construct($p_text="",string $p_class="")
    {
        $this->text=$p_text;
        $this->class=$p_class;
        $this->setContainerHeight("");
        $this->setContainerWidth("");
        parent::__construct();
    }
    
    
    /**
     * Set the static text displayed on the page
     * 
     * @param string $p_text  Static text, doesn't need to be html escaped.
     */
    
    function setText(string $p_text):void
    {
        $this->text=$p_text;
    }
    
    /**
     * Get the static text.
     * 
     * @return string|NULL
     */
    function getText():?string
    {
        return $this->text;
    }
    /**
     * Set the CSS class for displaying the text.
     * 
     * @param string $p_class CSS class
     */
    function setClass(string $p_class):void
    {
        $this->class=$p_class;
    }
    
    /**
     * Get the CSS class used for displaying the text
     * @return string|NULL CSS class
     */
    
    function getClass():?string
    {
        return $this->class;
    }
    
    /**
     * Output the text
     * The text is html escaped before displaying it.  
     * When the class is set, the text is placed in a span element and the css class
     * of the span is set.
     */
    
    function display(?DataStore $p_store=null):void
    {
        if($this->class){
            ?><span class="<?=$this->theme->e($this->class)?>"><?=$this->theme->e($this->text)?></span><?php 
        } else {
            echo $this->theme->e($this->text);
        }
            
    }
}