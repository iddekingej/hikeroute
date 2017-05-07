<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Menu;

use App\Vc\Lib\ThemeItem;

class LeftMenu extends ThemeItem
{
    /**
     * Display menu group
     *
     * @param string $p_title
     */
    function menuGroup(string $p_title): void
    {
        ?>
<div class="leftmenu_group"><?=static::e($p_title)?></div>
<?php
    }
    function selectedMenu()
    {
        ?><div class="leftmenu_selected"><?php 
    }
    
    /**
     * Menu item
     *
     * @param unknown $p_route
     *            route to link
     * @param unknown $p_title
     */
    static function menuItem($p_route, $p_title)
    {
?>
<div class="leftmenu_item_con">
	<a class="leftmenu_item" href='<?=route($p_route)?>'><?=htmlspecialchars($p_title)?></a>
</div>
<?php
    }
    
    function selectedMenuFooter()
    {
        ?></div><?php    
    }
    function logoutMenu()
    {
        ?>
    
        <div class="leftmenu_item_con">
				<a class="leftmenu_item" href="#"
					onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					<?=$this->e(__("Logout"))?></a>
			</div>
			<form id="logout-form" action="<?=route('logout')?>" method="POST"
				style="display: none;"><?=csrf_field()?></form>			
		<?php 
    }
}		