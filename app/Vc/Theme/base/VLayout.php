<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;
class VLayout extends ThemeItem
{
    function header()
    {
        ?><div><?php 
    }

    function itemHeader()
    {
        ?><div><?php
    }
    
    function itemFooter()
    {
        ?></div><?php
    }
    
    function footer()
    {
        ?></div><?php 
    }
}