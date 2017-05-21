<?php 
declare(strict_types=1);
namespace App\Vc\Theme\Route;

use App\Vc\Lib\ThemeItem;
use App\Lib\Localize;
use App\Vc\RouteTracesVC;
use App\Models\Route;
use App\Vc\Trace\TraceDownloadLink;

class Info extends ThemeItem
{
    
   function routeTitle($p_name)
   {
       ?><div class="traces_route_title"><?=$this->e($p_name)?></div><?php
   }
    private function routeInfoRow($p_label, $p_value)
    {
        ?>
<tr>       
	<td class="map_ud"><?=$this->e($p_label)?></td>
	<td class="map_ud_value"><?=$this->e($p_value)?></td>
</tr>			
<?php
    }
   
    function albumLink(Route $p_route)
    {        
        ?><div><?php 
        $this->textRouteLink("display.album",["id"=>$p_route->id],__("Compleet album"));
        ?></div><?php 
    }
    
    function routeInfo($p_route)
    {
?><table><?php       
        $this->sectionHeader(__("Information"));
        $this->routeInfoRow(__("Location"), $p_route->location, 1, 2);
        $this->routeInfoRow(__("Distance"), Localize::meterToDistance((int)$p_route->routeTrace->distance));
		$this->routeInfoRow(__("Author"), $p_route->user->name, 1, 2);
		$this->routeInfoRow(__("Crearted on"), Localize::shortDate($p_route->created_at));
		$l_link=new TraceDownloadLink($p_route->routeTrace);
?>        		
	<tr>
		<td class="map_ud"><?=$this->e(__("Download route"))?>:</td>
		<td colspan='4' class="map_ud_value"><?=$l_link->display()?></td>
	</tr>
</table>
<?php
        if($p_route->comment!==null && strlen($p_route->comment)>0){
            $this->sectionHeader(__("Description"));
            ?><div class="map_comment"><?=$this->e($p_route->comment)?></div><?php
        }
    }
    
    function sectionHeader($p_title)
    {
        ?><div class="routeall_sectionTitle"><?=$this->e($p_title)?></div><?php    
    }
}