<?php 
declare(strict_types=1);
namespace App\Vc\Form;
use App\Vc\Lib\HtmlComponent;

abstract class FormElement extends HtmlComponent 
{
    private $id;
    private $rowId;
    private $value;
    private $label;
    private $error="";
    private $condition;
    
    function setError(string $p_error):void
    {
        $this->error=$p_error;
    }
    
    function getError():string
    {
        return $this->error;
    }
    
    function setRowId(string $p_rowId):void
    {
        $this->rowId=$p_rowId;
    }
    
    function getRowId():string
    {
        return $this->rowId;
    }
    
    function setId(string $p_id):void
    {
        $this->id=$p_id;
    }
    
    function getId():string
    {
        return $this->id;
    }
    
    function setValue($p_value):void
    {
        $this->value=$p_value;
    }
    
    function getValue()
    {
        return $this->value;
    }
    
    function setLabel(string $p_label):void
    {
        $this->label=$p_label;
    }
    
    function getLabel():string
    {
        return $this->label;
    }
    
    function setCondition(string $p_condition):void
    {
        $this->condition=$p_condition;
    }
    
    function hasData()
    {
        return false;
    }
    
    function getCondition()
    {
        return $this->condition;
    }

}