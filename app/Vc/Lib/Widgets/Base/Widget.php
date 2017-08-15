<?php
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Base;

use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\Engine\Data\DataLayer;
use App\Vc\Lib\Engine\Data\DataStore;

abstract class Widget extends HtmlComponent
{
    private $dataLayer;
    
    function getAttValue(string $p_name,DataStore $p_store,string $p_type="",bool $p_mandatory=false)
    {
        $l_method="get${p_name}";
        if(!method_exists($this,$l_method)){
            throw new UnkownAttributeException($this,$p_name);
        }
        $l_value=$this->$l_method();
        if($l_value !== null){
            $l_realValue = $l_value->getValue($p_store);
        } else {
            $l_realValue = null;
        }
        if($l_realValue === null){
            if($p_mandatory){
                throw new EmptyAttributeException($this, $p_name);
            }
            return null;
        } else if($p_type){
            if(is_object($l_realValue)){
        
                $l_realType=get_class($l_realValue);
            } else {
                $l_realType=gettype($l_realValue);
            }
            if($l_realType != $p_type){
                throw new InvalidAttributeValueException($this, $p_name,$p_type,$l_realType);
            }
        }
        
        return $l_realValue;
    }
    
    function setDataLayer(DataLayer $p_dataLayer)
    {
        $this->dataLayer=$p_dataLayer;
    }
    
    function getDataLayer():?DataLayer
    {
        return $this->dataLayer;
    }
    
    abstract function displayContent(?DataStore $p_store);
    
    final function display(?DataStore $p_store=null)
    {
        if($this->dataLayer){
            $l_store=$this->dataLayer->processData($p_store);
        } else {
            $l_store=$p_store;
        }
        $this->displayContent($l_store);
    }
}