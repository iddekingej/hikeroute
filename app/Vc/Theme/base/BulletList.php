<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;

class BulletList extends ThemeItem
{
    function listHeader()
    {
        ?><ul><?php         
    }
    
    function itemHeader()
    {
        ?><li><?php 
    }
    
    function itemFooter()
    {
        ?></li><?php   
    }
    
    function listFooter()
    {
        ?></ul><?php    
    }
}