<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Page;

use App\Vc\Lib\ThemeItem;

class MenuPage extends ThemeItem
{
    function MenuHeader()
    {
        ?>
<table id="main" class="leftmenu_table">
	<tr>
		<td class='leftmenu'>       
       <?php 
    }
    
    function contentSection()
    {
        ?>
        </td>
        <td class="pagecontent">
        <?php    
    }
    
    function menuPageFooter()
    {
        ?>
        </td>
        </tr>
        </table>
        <script type="text/javascript">gui.elementToPageHeight($("main"));</script>
        <?php
    }
    
}