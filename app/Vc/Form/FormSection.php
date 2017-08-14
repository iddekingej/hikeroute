<?php 
declare(strict_types=1);
namespace App\Vc\Form;

/**
 * Class used for a form section title
 *
 */
class FormSection extends FormElement
{
    /**
     * Section title
     * 
     * @var string 
     */
    private $title;
    
    /**
     * Set the section title. The text is html escaped before
     * it is displayed
     * 
     * @param string $p_title Section title
     */
    function setTitle(string $p_title):void
    {
        $this->title=$p_title;
    }
    
    /**
     * Get the section title.
     * 
     * @return string
     */
    
    function getTitle():string
    {
        return $this->title;
    }
    
    /**
     * Display the section title
     */
    
    function display()
    {
        $this->theme->base_Form->sectionTitle($this->title);        
    }
}