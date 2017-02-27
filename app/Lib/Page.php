<?php
namespace App\Lib;

/**
 * Helper function for views
 *
 */

class Page{

	/**
	 * Menu item
	 * 
	 * @param unknown $p_route  route to link
	 * @param unknown $p_title  
	 */
	static function menuItem($p_route,$p_title){
	?>
		<div class="leftmenu_item_con">
		<a class="leftmenu_item" href='<?=route($p_route)?>'><?=htmlspecialchars($p_title)?></a>
		</div>
	<?php 
	}
	
	static function topMenuHeader()
	{
	?>
		<div class="topMenu">
	<?php 	
	}
	
	static function topMenuItem($p_route,Array $p_parameters,$p_title)
	{
	?>
		<span class="topMenuItem"><a class='topMenuLink' href='<?=route($p_route,$p_parameters)?>'><?=htmlspecialchars($p_title)?></a></span>
	<?php 
	}
	
	static function topMenuFooter()
	{
		?>
		</div>
		<?php 	
	}
}

