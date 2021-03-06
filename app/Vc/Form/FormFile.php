<?php 
declare(strict_types=1);
namespace App\Vc\Form;
use XMLView\Engine\Data\DataStore;;

class FormFile extends FormInputElement
{
    function displayElement(?DataStore $p_store=null):void
    {
        $this->theme->base_Form->fileInput($this->getId(),$this->getName(),$this->getValue());
    }
}