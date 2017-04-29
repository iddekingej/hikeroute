<?php
namespace App\Exceptions;

use Exception;

class ValidationException extends Exception{
    private $field;
    
    function getField()
    {
        return $this->field;
    }
    
    function __constructor($p_field,$p_message)
    {
        $this->field=$p_field;
        parent::__construct($p_message);
    }
    
    function getData()
    {
        return [$this->field=>$this->message];
    }
}