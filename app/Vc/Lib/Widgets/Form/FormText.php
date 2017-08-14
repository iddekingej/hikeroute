<?php 
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Form;

use App\Vc\Lib\Engine\Data\DataStore;

/**
 * Displays a  single line text input element
 *
 */
class FormText extends FormInputElement
{
    function displayElement(?DataStore $p_store=null):void
    {
        $this->theme->base_Form->textElement($this->getId(),$this->getName(),$this->getRealValue($p_store));
    }
}