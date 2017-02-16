@extends('layouts.pageform',["title"=>__("Upload new GPX file")])
@section('formbody')
{!! Form::open(["route"=>"routes.save.newupload","enctype"=>"multipart/form-data"]) !!}
{!! Form::hidden("id",$id) !!}
<table class="form_table">
<tr>
	<td class="form_labelCell">
	{!! Form::label("gpxfile",__("GPX File")) !!}
	</td>
	<td class="form_labelElement">
	@if ($errors->has('routefile'))
			<div class="form_error">{{ $errors->first('routefile') }}</div>
	@endif	
	{!! Form::file("routefile") !!}
	</td>
</tr>
<tr>
	<td colspan='2'>
		{!! Form::submit(__("Next")) !!}
		<button type='button' onclick='window.location="{{ Route("routes") }}"'>Cancel</button>
	</td>
</tr>
</table> 
{!! Form::close() !!}
@endsection