<?php
use App\Vc\RouteTracesVC;
use App\Lib\Page;
use App\Vc\Trace\OpenLayer;
?>
@extends("layouts.pagemenu",["title"=>__("Route trace")])

@section("header")	
	<?php
RouteTracesVC::openLayerExtItems();
?>
@endsection
@section("pagebody")
<div class="map_container">
<?php
Page::topMenuHeader();
Page::topMenuitem('routes.newdetails', [
    'id' => $routeTrace->id
], __("Add as route"));
if (! $routeTrace->hasRoutes()) {
    Page::topMenuItemConfirm('traces.del', [
        'id' => $routeTrace->id
    ], __("Delete this route trace"), __("Delete this route trace?"));
}
Page::topMenuFooter();
?>
<table class="map_table">
<tr>
	<td>
		<?php RouteTracesVC::traceInfo($routeTrace);?>
	</td>
</tr>
<tr>
	<td>
<?php 
 $l_trace=new OpenLayer($routeTrace);
 $l_trace->display();
?>		
	</td>
</tr>
</table>
</div>
<?php
RouteTracesVC::routeList($routeTrace);
?>
@endsection()