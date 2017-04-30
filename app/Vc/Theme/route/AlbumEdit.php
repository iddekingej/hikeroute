<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;

class AlbumEdit extends ThemeItem
{
    function imageEditHeader()
    {
        ?><table><tr><td><?php 
    }
    
    function imageControls(){
        ?></td><td><?php 
    }
    
    function imageEditFooter()
    {
        ?></td></table><?php 
    }

}