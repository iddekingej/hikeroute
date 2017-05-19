<?php
declare(strict_types = 1);
namespace App\Vc;

use App\Vc\ViewComponent;
use App\Models\RouteTrace;
use App\Lib\Localize;

class RouteTracesVC extends ViewComponent
{

    /**
     * Link to download a gpx file
     * 
     * @param RouteTrace $p_trace            
     */
    static function downloadLink(RouteTrace $p_trace)
    {
        static::link(Route("traces.download", [
            "p_id" => $p_trace->id
        ]), __("Download file"));
    }

    /**
     * Print information about a trace
     *
     * @param RouteTrace $p_trace            
     */
    static function traceInfo(RouteTrace $p_trace)
    {
        ?>
<table>
	<tr>
		<td class="map_ud"><?=__("Uploaded by")?>:</td>
		<td class="map_ud_value"><?=static::e($p_trace->user->name)?></td>
	</tr>
	<tr>
		<td class="map_ud"><?=__("Location")?>:</td>
		<td class="map_ud_value"><?=static::e($p_trace->getLocationString())?></td>
	</tr>
	<tr>
		<td class="map_ud"><?=__("Recorded at")?>:</td>
		<td class="map_ud_value"><?=static::e(Localize::shortDate($p_trace->startdate))?></td>
	</tr>
	<tr>
		<td class="map_ud"><?=__("Distance")?>:</td>
		<td class="map_ud_value"><?=static::e(Localize::meterToDistance((int)$p_trace->distance))?></td>
	</tr>
	<tr>
		<td class="map_ud"><?=__("Download")?>:</td>
		<td class="map_ud_value"><?=self::downloadLink($p_trace)?></td>
	</tr>


</table>
<?php
    }


    static function routeList(RouteTrace $p_routeTrace): void
    {
        $l_routes = $p_routeTrace->routes;
        ?>
<div class="traces_route_title"><?=static::e(__("Routes using this trace"))?></div>
<?php if(count($l_routes)==0){?>
		<?=static::e(__("Nothing found"))?>
		<?php } else {?>
<ul>
		<?php
            foreach ($p_routeTrace->routes as $l_route) {
                ?>
			<li><?=static::link(Route("display.overview",$l_route->id),$l_route->title) ?></li>
		<?php }?>
		</ul>
<?php
        }
    }
}