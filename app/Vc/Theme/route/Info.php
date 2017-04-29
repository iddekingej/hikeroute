<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;
use App\Lib\Localize;
use App\Vc\RouteTracesVC;

class Info extends ThemeItem
{
    
    private function routeInfoRow($p_label, $p_value)
    {
        ?>
<tr>       
	<td class="map_ud"><?=$this->e($p_label)?></td>
	<td class="map_ud_value"><?=$this->e($p_value)?></td>
</tr>			
<?php
    }

    function routeInfo($p_route)
    {
?><table><?php         
        $this->routeInfoRow(__("Location"), $p_route->location, 1, 2);
        $this->routeInfoRow(__("Distance"), Localize::meterToDistance((int)$p_route->routeTrace->distance));
		$this->routeInfoRow(__("Author"), $p_route->user->name, 1, 2);
		$this->routeInfoRow(__("Crearted on"), Localize::shortDate($p_route->created_at));
?>        		
	<tr>
		<td class="map_ud"><?=$this->e(__("Download route"))?>:</td>
		<td colspan='4' class="map_ud_value"><?=RouteTracesVC::downloadLink($p_route->routeTrace)?></td>
	</tr>
	<tr>
		<td colspan='2' class='map_ud'><?=$this->e(__("Description"))?></td>
	<tr>
		<td class="map_comment"><?=$this->e($p_route->comment)?></td>
	</tr>							
</table>
<?php
    }
}