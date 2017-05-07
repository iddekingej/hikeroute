<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

use App\Vc\ViewComponent;

class TagExcpetion extends \Exception
{
    
}

class Tag
{
    private $properties;
    private $content;
    private $tag;
    private $parent;
    
    function __construct(String $p_tag)
    {
        $this->tag=$p_tag;
    }
    
    function setParent(Tag $p_parent)
    {
        $this->parent=$p_parent;
    }
    
    function inner($p_tag)
    {
        $l_tag=new Tag($p_tag);
        $l_tag->setParent($this);
        return $l_tag;
    }
    
    function endInner()
    {
        if($this->parent===NULL){
            throw new TagExcpetion("Tag has no parent tag");
        }
        $this->parent->content($this->__toString());
        return $this->parent;
    }
    
    function property($p_name,$p_value):Tag
    {
        $this->properties .= " ";        
        $this->properties .= $p_name.'="'.ViewComponent::e($p_value).'"';
        return $this;
    }
    
    function class($p_value):Tag
    {
        return $this->property("class",$p_value);
    }
    
    function id($p_value):Tag
    {
        return $this->property("id",$p_value);
    }
    
    function content($p_content):Tag
    {
        $this->content .= $p_content;
        return $this;
    }
    
    function text($p_content):Tag
    {
        return $this->content(ViewComponent::e($p_content));
    }
    function __toString():string
    {
        return "<".$this->tag.$this->properties.">".$this->content."</".$this->tag.">";       
    }
}
?>