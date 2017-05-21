<?php 
declare(strict_types=1);
namespace App\Vc\Theme\trace;

use App\Vc\Lib\ThemeItem;
use App\Models\RouteTrace;
use App\Lib\Localize;
use App\Vc\Trace\TraceDownloadLink;

class Show extends ThemeItem
{
    function container()
    {
        ?><div class="map_container"><?php 
        
    }
    function infoHeader()
    {
        ?>
        <table class="map_table">
        <tr>
        <td>
        <?php 
    }
    
    function mapHeader()
    {
        ?>
        </td>
        </tr>
        <tr>
        <td>
        <?php 
    }
    
    function mapFooter()
    {
?>
	</td>
</tr>
</table>
</div>
<?php 
    }
    
    function routeListTitle()
    {
?><div class="traces_route_title"><?=$this->e(__("Routes using this trace"))?></div><?php
    }
    
    function routeNothingFound()
    {
		?><?=static::e(__("Nothing found"));?><?php		
    }
    
    function routeListHeader()
    {
     ?><ul><?php    
    }
    
    function routeListItem($p_id,$p_title)
    {
?><li><?=$this->textRouteLink("display.overview",["p_id_route"=>$p_id],$p_title) ?></li><?php 
    }
    
    function routeListFooter()
    {
?></ul><?php 
    }
    
    
    /**
     * Print information about a trace
     *
     * @param RouteTrace $p_trace
     */
    function traceInfo(RouteTrace $p_trace)
    {
        $l_downloadLink=new TraceDownloadLink($p_trace);
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
		<td class="map_ud_value"><?php $l_downloadLink->display();?></td>
	</tr>


</table>
<?php
    }
}