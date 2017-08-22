<?php 
declare(strict_types=1);
namespace App\Vc\Form;


use XMLView\Engine\Data\DataStore;;

abstract class FormInputElement extends FormElement
{
    abstract function displayElement();
    
    function hasData()
    {
        return true;
    }
    
    final function display(?DataStore $p_store=null)
    {
        $this->theme->base_Form->rowHeader($this->getName(),$this->getLabel(),$this->getError(),$this->getRowId());
        $this->theme->base_Form->elementHeader();
        $this->displayElement($p_store);
        $this->theme->base_Form->rowFooter();
    }
}