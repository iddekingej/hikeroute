<?php
use App\Vc\RouteTracesVC;
?>
@extends("layouts.pagemenu",["title"=>__("Route trace")])

@section("header")	
	<?php
		RouteTracesVC::openLayerExtItems();	
	?>
@endsection
@section("pagebody")
<div class="map_container">

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
RouteTracesVC::openLayerJs($routeTrace);
?>
@endsection()