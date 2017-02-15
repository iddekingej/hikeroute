@extends('layouts.pageform',["title"=>"Upload new GPX file to existing route"])
@section('formbody')
{!! Form::open(["route"=>"routes.save.uploadgpx","enctype"=>"multipart/form-data"]) !!}
{!! Form::hidden("id",$id) !!}
<table class="form_table">
<tr>
	<td class="form_labelCell">
	{!! Form::label("gpxfile","GPX File") !!}
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
		{!! Form::submit("Save") !!}
		<button type='button' onclick='window.location="{{ Route("admin.users") }}"'>Cancel</button>
	</td>
</tr>
</table> 
{!! Form::close() !!}
@endsection