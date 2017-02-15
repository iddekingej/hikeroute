@extends('layouts.pageform',["title"=>$title])
@section('formbody')
{!! Form::open(["route"=>$id==""?"routes.save.add":"routes.save.edit","enctype"=>"multipart/form-data"]); !!}
{!! Form::hidden("id",$id) !!}
<table class="form_table">
<tr>
	<td class="form_labelCell">
	{!!Form::label("routeTitle","Title") !!}
	</td>
	<td class="form_elementCell">
		@if ($errors->has('routeTitle'))
			<div class="form_error">{{ $errors->first('routeTitle') }}</div>
		@endif 
	{!! Form::text("routeTitle",$routeTitle,["class"=>"form_valueElement"]) !!}	
	</td>
</tr>
<tr>
	<td class="form_labelCell">
	{!!Form::label("comment","Description") !!}
	</td>
	<td class="form_elementCell">
	{!!Form::textarea("comment",$comment,["class"=>"form_valueElement"]) !!}
	</td>
</tr>
@if($id=="")
<tr>
	<td class="form_labelCell">
	{!!Form::label("routefile","GPX file") !!}
	</td>
	<td class="form_elementCell">
	@if ($errors->has('routefile'))
			<div class="form_error">{{ $errors->first('routefile') }}</div>
	@endif	
	{!!Form::file("routefile") !!}
	</td>
</tr>
@endif
<tr>
	<td colspan='2'>
		{!! Form::submit("Save") !!}
		<button type='button' onclick='window.location="{{ Route("admin.users") }}"'>Cancel</button>
	</td>
</tr>

</table>
{!! Form::close() !!}
@endsection