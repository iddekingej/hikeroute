@extends("layouts.page")
@section("content")


<?php 	
	\App\Vc\RouteVC::routeSearch();	
	$l_cnt=1;
	$l_pars=""
?>
<div class="main_graybox">
<div><a href="/">{{ __("World") }}</a></div>
@foreach($tree as $location)

<div style='padding-left:{{ 5*$l_cnt}}px'><a href="/location/{{$l_pars}}{{$location->id}}">{{ $location->name }}</a></div>
<?php 
	$l_cnt++ ;
	$l_pars .= $location->id."/"; 
	?> 
@endforeach
@foreach($locations as $l_lrn)
<?php  ?>
<div style='padding-left:{{ 5*$l_cnt }}px'><a href="/location/{{$pars}}{{ $l_lrn->id }}">{{ $l_lrn->name }}({{ $l_lrn->num }})</a></div>
@endforeach
</div>

@foreach($routes as $l_route)

<div class="routeall_title">{{ $l_route->title}}</div>

<div class="routeall_body">
<table class="routeall_infoTable">
<tr>
	<td class="routeall_infoLabel">{{ __("Location") }} </td><td class="routeall_infoValue">{{ $l_route->location }} </td>
</tr>
<tr>
	<td class="routeall_infoLabel">{{ __("Added by") }}</td><td class="routeall_infoValue">{{ $l_route->user()->name }} </td>
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