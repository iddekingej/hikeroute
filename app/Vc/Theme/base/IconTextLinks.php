<?php
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;

class IconTextLinks extends ThemeItem
{
    function header()
    {
        ?><table><?php 
    }
    
    function row($p_icon,$p_route,Array $p_params,$p_text)
    {
        ?><tr><td><?php         
        $this->iconLink($p_route,$p_params,$p_icon);
        ?></td><td><?php 
        $this->textRouteLink($p_route,$p_params,$p_text);
        ?></td></tr><?php 
    }
    
    function footer()
    {
        ?></table><?php
    }
}