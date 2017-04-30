<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class Theme
{
    function __get($p_name)
    {
        $l_name=str_replace("_", "\\", $p_name);
        $l_className="\\App\\Vc\\Theme\\".$l_name;
        $this->$p_name=new $l_className($this);
        return $this->$p_name;
    }
    
    function textRouteLink($p_route,Array $p_params,$p_text)
    {
        $this->textLink(Route($p_route,$p_params),$p_text);
    }
    function textLink($p_url,$p_text)
    {
        ?><a href="<?=$this->e($p_url)?>"><?=$this->e($p_text)?></a><?php
    }
    
    function imageTextLink($p_url,$p_image,$p_text)
    {
        ?><a href="<?=$this->e($p_url)?>"><img src="<?=$this->e($p_image)?>" /><?=$this->e($p_text)?></a><?php   
    }
    
    /**
     * HTML Escape string
     *
     * @param String $p_string
     * @return string
     */
    function e($p_string): string
    {
        if ($p_string === null) {
            return "";
        }
        return htmlspecialchars("$p_string", ENT_QUOTES | ENT_HTML5);
    }
}