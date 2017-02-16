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
<a class="buttonLink" href="{{ Route( 'routes') }}">{{ __("Back to routes overview") }}</a>&nbsp;
<a class="buttonLink" href="{{ Route( 'routes.edit',['id'=>$id]) }}">{{ __("Edit route") }}</a> &nbsp;
<a class="buttonLink" href="{{ Route( 'routes.updategpx',['id'=>$id]) }}">{{ __("Upload new gpx file") }}</a>
<a class="buttonLink" href="{{ Route( 'routes.del',['id'=>$id]) }}">{{ __("Delete this route") }}</a>
@endif
<td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td class="map_ud" colspan='1'>{{ __("Location") }}</td>
			<td class="map_ud_value" colspan='4'>{{ $location }}</td>
		</tr>
		<tr>
			<td class="map_ud">{{ __("Uploaded by") }}:</td>
			<td class="map_ud_value">{{ $creator }} </td>
			<td class="map_ud_space">&nbsp</td>
			<td class="map_ud">{{ __("Uploaded on") }}:</td>
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
	l_map.setGpxRoute({!! json_encode(Route("routes.download",["p_id"=>$id_routefile])) !!});
	l_map.setSize({{ $info->minLat }},{{ $info->maxLat }} , {{ $info->minLon }} , {{ $info->maxLon}});
	l_map.displayMap();
</script>

@endsection