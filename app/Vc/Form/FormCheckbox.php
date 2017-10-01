<?php 
declare(strict_types=1);
namespace App\Vc\Form;

use XMLView\Engine\Data\DataStore;

class FormCheckbox extends FormInputElement
{
    function displayElement(?DataStore $p_store=null):void
    {
        
        $this->theme->base_Form->checkboxElement($this->getId(),$this->getRealElementName($p_store),$this->getValue());        
    }
}