<?php
use App\Vc\RouteTracesVC;
?>
@extends('layouts.pageform',["title"=>$title])

@section("header")
<script src="/js/ol.js"></script>
<link href="/css/ol.css" rel='stylesheet'></link>
@endsection @section('formbody')
<table class="map_table">
		<?php RouteTracesVC::openLayerDiv();?>		
</table>
{!!
Form::open(["route"=>$id==""?"routes.save.add":"routes.save.edit","enctype"=>"multipart/form-data"]);
!!} {!! Form::hidden("id",$id) !!} {!!
Form::hidden("id_routetrace",$routeTrace->id) !!}
<table class="form_table">
	<tr>
		<td class="form_labelCell">{!!Form::label("routeTitle",__("Title"))
			!!}</td>
		<td class="form_elementCell">@if ($errors->has('routeTitle'))
			<div class="form_error">{{ $errors->first('routeTitle') }}</div>
			@endif {!!
			Form::text("routeTitle",$routeTitle,["class"=>"form_valueElement"])
			!!}
		</td>
	</tr>
	<tr>
		<td class="form_labelCell">{!! Form::label("routeLocation",__("Start
			location")) !!}</td>
		<td class="form_elementCell">{!!
			Form::text("routeLocation",$routeLocation,["class"=>"form_valueElement"]);
			!!}</td>
	</tr>
	{!! \App\Lib\Frm::checkbox("publish",__("Publish"),$publish) !!}
	<tr>
		<td class="form_labelCell">
			{!!Form::label("comment",__("Description")) !!}</td>
		<td class="form_elementCell">
			{!!Form::textarea("comment",$comment,["class"=>"form_valueElement"])
			!!}</td>
	</tr>
	<tr>
		<td colspan='2'>{!! Form::submit("Save") !!}
			<button type='button'
				onclick='window.location="{{ Route("routes") }}"'>Cancel</button>
		</td>
	</tr>

</table>
<?php
RouteTracesVC::openLayerJs($routeTrace);
?>
{!! Form::close() !!}
@endsection