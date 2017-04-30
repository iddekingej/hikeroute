<?php
declare(strict_types = 1);
namespace App\Lib;

use App\Vc\ViewComponent;

/**
 * Helper function for views
 */
class Page extends ViewComponent
{

    /**
     * Display menu group
     *
     * @param string $p_title            
     */
    static function menuGroup(string $p_title): void
    {
        ?>
<div class="leftmenu_group"><?=static::e($p_title)?></div>
<?php
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

    static function topMenuHeader()
    {
        ?>
<div class="topMenu">
	<?php
    }

    static function topMenuItem($p_route, Array $p_parameters, $p_title,$p_icon)
    {
        ?>
		<span class="topMenuItem">
			<a class='topMenuLink' href='<?=route($p_route,$p_parameters)?>'>
			<?php if($p_icon){?>
			<img src='<?=$p_icon?>' />
			<?php }?>
			<?=htmlspecialchars($p_title)?>
			</a>
		</span>
	<?php
    }

    static function topMenuItemConfirm($p_route, Array $p_parameters, $p_title,$p_icon, $p_message)
    {
        $l_js = self::confirmJs($p_message, route($p_route, $p_parameters));
        ?>
			<span class="topMenuItem">
				<a class='topMenuLink' href='#' onclick='<?=self::e($l_js)?>'>
				<?php if($p_icon){?>
					<img src='<?=$p_icon?>' />
				<?php }?>
				<?=htmlspecialchars($p_title)?>
				</a>
			</span>
		<?php
    }

    static function topMenuFooter()
    {
        ?>
		</div>
<?php
    }

    /**
     * After clicking a icon, a confirmation message is displayed
     * After pressing "yes"
     *
     * @param unknown $p_message
     *            Confirmation message to display
     * @param unknown $p_url
     *            Url to go after click + confirmation
     * @param unknown $p_image
     *            Url of icon/image
     */
    static function iconConfirm(string $p_message, string $p_url, string $p_image): void
    {
        $l_js = self::confirmJs($p_message, $p_url);
        ?><span class="deleteIcon" onclick="<?=self::e($l_js)?>"><img
	src='<?=self::e($p_image)?>'></span><?php
    }

    // Dual column layout
    // Left an menu and right the content
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
	<tr>
		<td class="main_column_left">
<?php
    }

    /**
     * Content header(right column) Between left and right column
     */
    static function dcContentHeader()
    {
        ?>
</td>
		<td class="main_column_right">
<?php
    }

    /**
     * DC Footer code (javascript is for enlarging content until page size
     */
    static function dcFooter()
    {
        ?>
</td>
	</tr>
</table>
<script type="text/javascript">gui.elementToPageHeight($("main"));</script>
<?php
    }
}

