<?php
use App\Vc\RouteTracesVC;
use App\Lib\Page;
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
Page::topMenuitem('routes.newdetails',['id'=>$routeTrace->id],__("Add as route")); 
Page::topMenuFooter();
?>
<table class="map_table">
<tr>
	<td>
		<?php RouteTracesVC::traceInfo($routeTrace);?>
	</td>
</tr>
<?php RouteTracesVC::openLayerDiv();?>		
</table>
</div>
<?php 
RouteTracesVC::routeList($routeTrace);
RouteTracesVC::openLayerJs($routeTrace);
?>
@endsection()