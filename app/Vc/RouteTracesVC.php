<?php 
declare(string_types=1);
namespace App\Vc;
use App\Vc\ViewComponent;
use App\Models\RouteTrace;
use App\Lib\Localize;
use App\Lib\Page;

class RouteTracesVC extends ViewComponent
{
	
	/**
	 * Header of list with all user's traces
	 * Usage:
	 * ::tracelistHeader
	 * ::traceListRow (for each route trace)
	 * ::traceListFooter
	 */
	static function traceListHeader()
	{
		Page::topMenuHeader();
		Page::topMenuItem("traces.upload", [], __("Upload new gpx"));
		Page::topMenuFooter();
?>
<table class="table">
<tr>
	<td colspan="6" class="table_title"><?=__("List of route traces")?></td>
</tr>
<tr>
	<td class="table_header">
	</td>
	<td colspan='4' class="table_header">
		<?=__("Location")?>
	</td>
	<td class="table_header">
		<?=__("Record date")?>
	</td> 
	<td class="table_header">
		<?=__("Distance")?>
	</td>
	<td class="table_header">
		<?=__("Has route")?>
	</td>
</tr>
<?php 
	}
	
	static function downloadLink(RouteTrace $p_trace)
	{
		static::link(Route("traces.download",["p_id"=>$p_trace->id]),__("Download file"));	
	}
	
	/**
	 * Print table row with information about a trace
	 * Used in list with all the users uploaded route traces
	 * 
	 * @param RouteTrace $p_trace display information about this trace
	 */
	
	static function traceListRow(RouteTrace $p_trace)
	{
		
?>
	<tr>
		<td class="table_cell">
			<?=static::editLink("traces.show",["p_id"=>$p_trace->id],"")?>
		</td>
		<td class="table_cell">
		<?=static::e($p_trace->getLocationByTypeCached("country"))?>
		</td>
		<td class="table_cell">
		<?=static::e($p_trace->getLocationByTypeCached("state"))?>
		</td>
		<td class="table_cell">
		<?=static::e($p_trace->getLocationByTypeCached("city"))?>
		</td>
		<td class="table_cell">
		<?=static::e($p_trace->getLocationByTypeCached("suburb"))?>
		</td>
		<td class="table_cell">
		<?=static::e(Localize::shortDate($p_trace->startdate))?>
		</td>
		<td class="table_cell">
		<?=static::e((string)round($p_trace->distance/1000))?>
		</td>
		<td class="table_cell">
		<?=$p_trace->hasRoutes()?"X":""?>
		</td>

	</tr>
<?php 
	}
	
	static function traceListFooter()
	{
?>
	</table>
<?php 
	}	
	
	/**
	 * Js and css file needed for openlayers
	 * This must be placed in the head of the page
	 */
	
	static function openLayerExtItems()
	{
		?>
		<script src="/js/ol.js" ></script>
		<link href="/css/ol.css" rel='stylesheet'></link>
		<?php 
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
			<td class="map_ud_value"><?=static::e($p_trace->user()->name)?></td>
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
			<td class="map_ud_value"><?=static::e(Localize::meterToDistance($p_trace->distance))?></td>
		</tr>
		<tr>
			<td class="map_ud"><?=__("Download")?>:</td>
			<td class="map_ud_value"><?=self::downloadLink($p_trace)?></td>
		</tr>


	</table>
	<?php 	
	}
	
	/**
	 * The map is displayed inside this DIV
	 */
	static function openLayerDiv()
	{
		?>
		<tr>
			<td class="map_body">		
				<div id='map'></div>
			</td>
		</tr>
		<?php 
	}
	
	/**
	 * Print initialise JS for displaying the route 
	 * 
	 * @param RouteTrace $p_routeTrace
	 */
	static function openLayerJs(RouteTrace $p_routeTrace):void
	{
	?>
<script type='text/javascript'>
	l_map=new RouteMap("map");
	l_map.setGpxRoute(<?=json_encode(Route("routes.download",["p_id"=>$p_routeTrace->id_routefile]))?>);
	l_map.setSize(<?=($p_routeTrace->minlat)?>,<?=($p_routeTrace->maxlat)?> , <?=($p_routeTrace->minlon)?> , <?=($p_routeTrace->maxlon)?>);
	l_map.displayMap();
</script>	
	<?php 	
	}
	
	static function routeList(RouteTrace $p_routeTrace):void
	{
		$l_routes=$p_routeTrace->routes();
		?>
		<div class="traces_route_title"><?=static::e(__("Routes using this trace"))?></div>
		<?php if(count($l_routes)==0){?>
		<?=static::e(__("Nothing found"))?>
		<?php } else {?>
		<ul>
		<?php 
		foreach($p_routeTrace->routes() as $l_route){
		?>
			<li><?=static::link(Route("routes.display",$l_route->id),$l_route->title) ?></li>
		<?php }?>
		</ul>
		<?php 
		}
	}
}