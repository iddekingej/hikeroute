<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Menu;

use App\Vc\Lib\ThemeItem;

class LeftMenu extends ThemeItem
{
    function MenuHeader()
    {
       ?>
<table class="leftmenu_table">
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
        <?php    
    }
    
    function logoutMenu()
    {
        ?>
    
        <div class="leftmenu_item_con">
				<a class="leftmenu_item" href="{{ route('logout') }}"
					onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					<?=$this->e(__("Logout"))?></a>
			</div>
			<form id="logout-form" action="{{ route('logout') }}" method="POST"
				style="display: none;">{{ csrf_field() }}</form>			
		<?php 
    }
}		