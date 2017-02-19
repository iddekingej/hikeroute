@extends("layouts.page")
@section("content")
@foreach($routes as $l_route)
<div class="routeall_title">{{ $l_route->title}}</div>
<div class="routeall_body">
<table class="routeall_infoTable">
<tr>
	<td class="routeall_infoLabel">{{ __("Location") }} </td><td class="routeall_infoValue">{{ $l_route->location }} </td>
</tr>
<tr>
	<td class="routeall_infoLabel">{{ __("Added by") }}</td><td class="routeall_infoValue">{{ $l_route->user()->getResults()->name }} </td>
</tr>
</table>
<br/>
&nbsp;<a href="{{ Route('routes.display',['id'=>$l_route->id]) }}">{{ __("Goto route details") }}</a><br/>
<pre>
{{ $l_route->comment }}
</pre>
</div>
@endforeach
@endsection