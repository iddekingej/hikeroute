<?php
declare(strict_types = 1);
namespace App\Vc;

use App\Vc\Lib\Tag;

class ViewComponent
{

    /**
     * HTML Escape string
     *
     * @param String $p_string            
     * @return string
     */
    static function e($p_string): string
    {
        if ($p_string === null) {
            return "";
        }
        return htmlspecialchars("$p_string", ENT_QUOTES | ENT_HTML5);
    }


    /**
     * Print text link
     *
     * @param string $p_url
     *            Url to link to
     * @param string $p_text
     *            Text to display in link
     */
    static function link(string $p_url, string $p_text): void
    {
        ?><a href="<?=self::e($p_url)?>"><?=self::e($p_text)?></a><?php
    }

    /**
     * Print text link by route
     *
     * @param string $p_route
     *            Route name
     * @param array $p_data
     *            Route parameters
     * @param string $p_text
     *            Text in link
     */
    static function linkRoute(string $p_route, Array $p_data, string $p_text): void
    {
        self::link(Route($p_route, $p_data), $p_text);
    }


    static function tag(string $p_tag):Tag
    {
        return new Tag($p_tag);
    }      
    
    static function div():Tag
    {
        return self::tag("div");
    }        
}
?>