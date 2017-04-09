<?php
use App\Vc\RouteTracesVC;
use App\Vc\RouteVC;
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
\App\Lib\Page::topMenuitem('routes.trace.edit',['id'=>$id],__("Upload new gpx file")); 
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
		<?php
		RouteVC::routeInfo($route);
		?>
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