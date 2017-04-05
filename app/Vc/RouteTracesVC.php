<?php 
declare(string_types=1);
namespace App\Vc;
use App\Vc\ViewComponent;
use App\Models\RouteTrace;

class RouteTracesVC extends ViewComponent
{
	static function traceListHeader()
	{
?>
<table class="table">
<tr>
	<td colspan="6" class="table_title"><?=__("List of route traces")?></td>
</tr>
<tr>
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
	
	static function traceListRow(RouteTrace $p_trace)
	{
?>
	<tr>
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
		<?=static::e($p_trace->startdate)?>
		</td>
		<td class="table_distance">
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
}