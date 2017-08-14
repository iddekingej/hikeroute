<?php
declare(strict_types=1);
namespace App\Vc\Lib\Widgets\Base;

use App\Vc\Lib\HtmlComponent;
use App\Vc\Lib\Engine\Data\DataLayer;
use App\Vc\Lib\Engine\Data\DataStore;

abstract class Widget extends HtmlComponent
{
    private $dataLayer;
    
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