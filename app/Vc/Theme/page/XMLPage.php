<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Page;

use App\Lib\Icons;
use XMLView\Widgets\Base\ThemeItem;

class XMLPage extends ThemeItem
{
	/**
     * This is for transition from PHP VC to XML VC's. Can be removed when completed
     */
    function themeHeader()
    {
        ?>
        <div class="apptitle">
		<table class="apptitle_table">
			<tr>
				<td class="apptitle_title"><?=__("Hiking routes")?></td>
				<td class="apptitle_name">
					<?php 
					if(!\Auth::user()){
						$this->textRouteLink("login",[],__("Login"),"buttonLink");
						echo "&nbsp;|&nbsp;";
						$this->textRouteLink("register",[],__("Register"),"buttonLink");
					} else {
					    $this->iconTextRouteLink("user.profile",[],Icons::USERSMALL,\Auth::user()->name,"buttonLink");
					}
                    ?>
				</td>
			</tr>
		</table>
	</div>
        <?php 
    }
}   