<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Form;

use App\Vc\Lib\Engine\Data\DataStore;

class FormFile extends FormInputElement
{
    function displayElement(?DataStore $p_store=null):void
    {
        $this->theme->base_Form->fileInput($this->getId(),$this->getName(),$this->getRealValue($p_store));
    }
}