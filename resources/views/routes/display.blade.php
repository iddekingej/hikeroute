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
<a class="buttonLink" href="{{ Route( 'routes') }}">Back to routes overview</a>&nbsp;
<a class="buttonLink" href="{{ Route( 'routes.edit',['id'=>$id]) }}">Edit route</a> &nbsp;
<a class="buttonLink" href="{{ Route( 'routes.editfile',['id'=>$id]) }}">Upload new gpx file</a>
<a class="buttonLink" href="{{ Route( 'routes.del',['id'=>$id]) }}">Delete this route</a>
@endif
<td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td class="map_ud">creator:</td>
			<td class="map_ud_value">{{ $creator }} </td>
			<td class="map_ud_space">&nbsp</td>
			<td class="map_ud">Uploaded:</td>
			<td class="map_ud_value"> {{ $uploadDate->format('d-m-Y') }}</td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td class="map_body">
		<div id='map'></div>
	</td>
</tr>
<tr>
	<td class="map_comment">
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