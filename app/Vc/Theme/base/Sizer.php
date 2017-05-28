<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;

class Sizer extends ThemeItem
{
    function sizerHeader()
    {
        ?><table class="sizer_con"><?php 
    }
    
    function sizerFooter()
    {
        ?></table><?php   
    }
    
    function rowHeader()
    {
        ?><tr><?php 
    }
    function cellHeader($p_style)
    {

        ?><td style="<?=$this->e($p_style)?>"><?php   
    }
    
    function cellFooter()
    {
        ?></td><?php 
    }
    
    function rowFooter()
    {
        ?></tr><?php    
    }
}