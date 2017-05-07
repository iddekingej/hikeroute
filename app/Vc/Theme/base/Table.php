<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;

class Table extends ThemeItem
{
    /**
     * Print Icon link
     * 
     * @param string $p_href   url of link
     * @param string $p_icon   icon url
     */
    
    function iconLink(string $p_href,string $p_icon):void
    {
        echo static::tag("a")->property("href",$p_href)->inner("img")->property("src",$p_icon)->endInner();
    }
}