<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use XMLView\Engine\Data\DataStore;;

/**
 * When conditionValue==true: HTML is generated from the sub elements 
 *                      false: No html or js is generated.
 */
class Condition extends HtmlComponent{
    use SubItems{
        getJs as private getJsTrait;
        getCss as private getCssTrait;
    }
    
    private $conditionValue;
    
    function getJs()
    {
        if($this->conditionValue){
            return $this->getJsTrait();
        }
        return [];
    }
    
    function getCss()
    {
        if($this->conditionValue){
            return $this->getCssTrait();
        }
        return [];
    }
    
    function setConditionValue($p_conditionValue):void
    {
        $this->conditionValue=$p_conditionValue;
    }
    
    function display(?DataStore $p_store=null)
    {
        if($this->conditionValue){
            foreach($this->subItems as $l_item){
                $l_item->display();
            }
        }
    }
}