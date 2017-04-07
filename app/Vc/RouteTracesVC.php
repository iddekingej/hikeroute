<?php 
declare(string_types=1);
namespace App\Vc;
use App\Vc\ViewComponent;
use App\Models\RouteTrace;
use App\Lib\Localize;

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
}