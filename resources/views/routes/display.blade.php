<?php
use App\Vc\RouteTracesVC;
?>
@extends("layouts.page",["title"=>$route->title])

@section("header")	
	<?php
		RouteTracesVC::openLayerExtItems();	
	?>
@endsection

@section("content")
<table class="map_pageTable">
<tr>

<td class="map_menuCell">
<div class="leftmenu_item_con">
<a class="buttonLink" href="/">{{ __("All routes") }}</a>
</div>
@if($canEdit)
<div class="leftmenu_item_con">
<a class="buttonLink" href="{{ Route( 'routes') }}">{{ __("Back to routes overview") }}</a>
</div>
@endif
</td>

<td >
@if($canEdit)
<?php  
\App\Lib\Page::topMenuHeader(); 
\App\Lib\Page::topMenuitem('routes.edit',['id'=>$id],__("Edit route")); 
\App\Lib\Page::topMenuitem('routes.updategpx',['id'=>$id],__("Upload new gpx file")); 
\App\Lib\Page::topMenuitemConfirm('routes.del',['id'=>$id],__("Delete this route"),__("Delete route?")); 
\App\Lib\Page::topMenuFooter();
?>
@endif

<div class="map_container">
<table class="map_table">
<tr>
	<td class="map_title">
	{{ $route->title }}
	</td>
</tr>
<tr>
<td>

<td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td class="map_ud" colspan='1'>{{ __("Location") }}</td>
			<td class="map_ud_value" colspan='2'>{{ $route->location }}</td>
				<td class="map_ud">{{ __("Distance") }}:</td>
			<td class="map_ud_value"> {{ $distance }}km</td>
		</tr>
		<tr>
			<td class="map_ud">{{ __("Uploaded by") }}:</td>
			<td class="map_ud_value">{{ $creator }} </td>
			<td class="map_ud_space">&#160;</td>
			<td class="map_ud">{{ __("Uploaded on") }}:</td>
			<td class="map_ud_value"> {{ $uploadDate->format('d-m-Y') }}</td>
		</tr>
		<tr>
			<td class="map_ud">{{ __("Download route") }}:</td>
			<td colspan='4' class="map_ud_value"><?=RouteTracesVC::downloadLink($route->routeTrace)?></td>
		</tr>
	</table>
	</td>
</tr>
<?php RouteTracesVC::openLayerDiv();?>		
<tr>
	<td class="map_comment">
		{{ $route->comment }}
	</td>
</table>
</div>
</td>
</tr>
</table>
<?php 
RouteTracesVC::openLayerJs($route->routeTrace);
?>

@endsection