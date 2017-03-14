@extends("layouts.pagemenu",["title"=>__("User routes")])
@section("pagebody")
<div class="buttonBar"><a href='{{ route("routes.new") }}' class='buttonLink'>
<img src='/images/adduser.png'>{{ __("Add new route") }}</a></div>
<table class="table">
<tr><td colspan='3' class="table_title">{{ __("List of routes") }}</td></tr>
<tr>
	<td class="table_header">
		&nbsp;
	</td>
	<td class="table_header">
		{{ __("Title") }}
	</td>
	<td class="table_header">
		{{ __("Create date") }}
	</td>
	<td class ="table_header">
		{{ __("Record date") }}
	</td>
	<td class ="table_header">
		{{ __("Distance") }}
	</td>
	<td class="table_header">
		{{ __("Published") }}
	</td>
</tr>
@foreach($routes as $l_route)
<tr>
	<td class="table_cell">
	</td>
	<td class="table_cell">
		<a href="{{ Route('routes.display',['id'=>$l_route->id]) }}">
			{{ $l_route->title }}
		</a>
	</td>
	<td class="table_cell">
			{{ $l_route->created_at->format('d-m-Y') }}
	</td>
	<td class="table_cell">
			{{ $l_route->routeFile()->getResults()->startdate }}
	</td>
	<td class="table_cell">
			{{ round($l_route->distance)/1000 }}
	</td>
	<td class="table_cell">
			{{ $l_route->publish?__("Yes"):"" }}
	</td>
</tr>
@endforeach
</table>
@endsection