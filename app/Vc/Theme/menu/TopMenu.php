<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Menu;

use App\Vc\Lib\ThemeItem;

class TopMenu extends ThemeItem
{
    function topMenuHeader()
    {
        ?>
<div class="topMenu">
	<?php
    }

    function topMenuItem($p_route, Array $p_parameters, $p_title,$p_icon)
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

    function topMenuItemConfirm($p_route, Array $p_parameters, $p_title,$p_icon, $p_message)
    {
        $l_js = $this->theme->confirmJs($p_message, route($p_route, $p_parameters));
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

    function topMenuFooter()
    {
        ?>
		</div>
<?php
    }
}