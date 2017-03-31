<?php
namespace App\Lib;

use App\Vc\ViewComponent;

/**
 * Helper function for views
 *
 */

class Page extends ViewComponent{


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
	
	static function topMenuItemConfirm($p_route,Array $p_parameters,$p_title,$p_message)
	{
		$l_js=self::confirmJs($p_message, route($p_route,$p_parameters))
		?>
			<span class="topMenuItem" ><a class='topMenuLink' href='#' onclick='<?=self::e($l_js)?>'><?=htmlspecialchars($p_title)?></a></span>
		<?php 
	}
	
	static function topMenuFooter()
	{
		?>
		</div>
		<?php 	
	}
	
	static function iconConfirm($p_message,$p_url,$p_image)
	{
		$l_js=self::confirmJs($p_message,$p_url);
		?><span class="deleteIcon" onclick="<?=self::e($l_js)?>"><img src='<?=self::e($p_image)?>'></span><?php
	}	
	
	static function editLink($p_route,Array $p_parameters,$p_message)
	{
		?><a href="<?=self::e(route($p_route,$p_parameters))?>"><img src='<?=self::e(\App\Lib\Icons::EDIT)?>'/><?=self::e($p_message)?></a><?php 
	}
	
	//Dual column layout
	//Left an menu and right the content
	/**
	 * Header of DC
	 * Usage
	 * -dcHeader
	 * -left column content
	 * -dcContentHeader
	 * -right content
	 * -dcFooter
	 */
	static function dcHeader()
	{
?>
<table id="main" class="main_table">
<tr><td class="main_column_left">
<?php 
	}
	/**
	 * Content header(right column) Between left and right column
	 */
	static function dcContentHeader()
	{
?>
</td><td class="main_column_right">
<?php 
	}
	
	/**
	 * DC Footer code (javascript is for enlarging content until page size
	 */
	
	static function dcFooter()
	{
?>
</td></tr>
</table>
<script type="text/javascript">gui.elementToPageHeight($("main"));</script>
<?php 
	}
}

