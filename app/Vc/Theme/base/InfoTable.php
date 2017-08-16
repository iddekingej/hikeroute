<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Base;

use App\Vc\Lib\ThemeItem;

class InfoTable extends ThemeItem
{
    function header($p_title)
    {
        ?><table class="infotable_table">
        	<tr>
        		<td colspan='2' class="infotable_title">
        			<?=static::e($p_title)?>
        		</td>
        	</tr>
        <?php        
    }
    
    function labelHeader()
    {
        ?><tr><?php    
    }
   
   function valueFooter()
   {
       ?></tr><?php 
   }
   
   function itemHeader($p_label)
   {
    ?><tr><td class="infotable_label"><?=static::e($p_label)?></td><td class="infotable_value"><?php    
   }
   
   
   function itemFooter()
   {
       ?></td></tr><?php 
   }
   
   function footer()
   {
       ?></table><?php 
   }
}