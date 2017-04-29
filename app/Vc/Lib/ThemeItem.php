<?php 
declare(strict_types=1);
namespace App\Vc\Lib;

class ThemeItem{
    
    private $theme;
    
    function __construct(Theme $p_theme)
    {
        $this->theme=$p_theme;       
    }
    
    /**
     * Get the theme manager
     * 
     * @return \App\Vc\Lib\Theme
     */
    
    function getTheme()
    {
        return $this->theme;
    }
    
    /**
     * Create tag object
     * 
     * @param string $p_tag
     * @return Tag
     */
    function tag(string $p_tag):Tag
    {
        return new Tag($p_tag);
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
    
    function textRouteLink($p_route,Array $p_params,$p_text)
    {
        $this->textLink(Route($p_route,$p_params),$p_text);
    }
    function textLink($p_url,$p_text)
    {
        ?><a href="<?=$this->e($p_url)?>"><?=$this->e($p_text)?></a><?php 
    }

}