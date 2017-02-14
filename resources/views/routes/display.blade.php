@extends("layouts.page")

@section("header")
	<script src="/js/ol.js" ></script>
	<link href="/css/ol.css" rel='stylesheet'></link>
@endsection

@section("content")
<div class="map_container">
<table class="map_table">
<tr>
	<td class="map_title">
	{{ $title }}
	</td>
</tr>
<tr>
<td>
@if($canEdit)
<a href="{{ Route( 'routes') }}">Back to routes overview</a>&nbsp;
<a href="{{ Route( 'routes.edit',['id'=>$id]) }}">Edit route</a> &nbsp;
<a href="{{ Route( 'routes.editfile',['id'=>$id]) }}">Upload new gpx file</a>
<a href="{{ Route( 'routes.del',['id'=>$id]) }}">Delete this route</a>
@endif
<td>
</tr>
<tr>
	<td class="map_body">
		<div id='map'></div>
	</td>
</tr>
<tr>
	<td>
		{{ $comment }}
	</td>
</table>
</div>
<script type='text/javascript'>
	l_map=new RouteMap("map");
	l_map.setGpxRoute({!! json_encode(Route("routes.download",["p_id"=>$id])) !!});
	l_map.setSize({{ $info->minLat }},{{ $info->maxLat }} , {{ $info->minLon }} , {{ $info->maxLon}});
	l_map.displayMap();
</script>

@endsection