<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

/**
 * SubItems trait used in sizers 
 * This trait is deprecated. 
 *
 */
trait SubItems{
    protected $subItems=[];
    
    /**
     * Get the URL of JS files Used in child elements
     *   
     * @return array List of JS File url's
     */
    function getJs():array
    {
        $l_js=[];
        foreach($this->subItems as $l_item){
            $l_js=array_merge($l_js,$l_item->getJs());
        }
        return array_unique($l_js);
    }
    
    function getCss():array
    {
        $l_css=[];
        foreach($this->subItems as $l_item){
            $l_css=array_merge($l_css,$l_item->getCss());
        }
        return array_unique($l_css);
    }
    
    function add(HtmlComponent $p_component,$p_width=null,$p_height=null,String $p_align=Align::LEFT){
        $l_component=new SizerItem($p_component);
        if($p_width !== null){
            $l_component->setWidth($p_width);
        }
        if($p_height != null){
            $l_component->setHeight($p_height);
        }
        $l_component->setAlign($p_align);
        $l_component->setParent($this);
        $this->subItems[]=$l_component;
        return $l_component;
    }
}