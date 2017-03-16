@extends('layouts.pageform',["title"=>$title])
@section('formbody')

{!! Form::open(["route"=>["admin.users.save.$cmd"],"autocomplete"=>"off"]) !!}
{!! Form::hidden("id",$id) !!}
<input type='text' style='display:none'/>
<input type='password' style='display:none' />
<table class="form_table">
<?php \App\Lib\Frm::text("name", __("Nick name"), $name, $errors)?>
<?php \App\Lib\Frm::text("firstname", __("First name"), $firstname, $errors)?>
<?php \App\Lib\Frm::text("lastname", __("Last name"), $lastname, $errors)?>
<tr>
	<td class="form_labelCell"> {!! Form::label("email","Email") !!}</td>
	<td class="form_elementCell"> 
		@if ($errors->has('email'))
			<div class="form_error">{{ $errors->first(__('email')) }}</div>
		@endif 
	{!! form::email("email",$email,["class"=>"form_valueElement"]) !!}
	</td>
</tr>
@if($id!="")
<tr>
	<td class="form_labelCell">
		{!! Form::label("resetpassword",__("Reset password ?")) !!}
	</td>
	<td class="form_elementCell">
		{!! Form::checkBox("resetpassword",1,false,["onclick"=>"gui.displayId('password',this.checked);gui.displayId('passwordconf',this.checked)"]) !!}
	</td>
</tr>
@endif
<?php 
\App\Lib\Frm::password("password","Password",$errors,"password","display:".($id==""?"":"none"));
\App\Lib\Frm::password("passwordconf","Password confirmation",$errors,"passwordconf","display:".($id==""?"":"none"));
?>
<tr>
<td colspan='2'  class='form_section'>
Rights
</td>
</tr>
<!-- Print selection of rights -->
@foreach($rights as $l_right)
<tr>
	<td>
		{!! Form::label("right_".$l_right[0]->id,$l_right[0]->description) !!}
	</td>
	<td>
		{!! Form::checkbox("right_".$l_right[0]->id,1,$l_right[1]) !!}
	</td>
</tr>
@endforeach
<tr>
	<td colspan='2' class="form_submitCell">
		{!! Form::submit("Save") !!}
		<button type='button' onclick='window.location="{{ Route("admin.users") }}"'>{{ __("Cancel") }}</button>
	</td>
</tr>

</table>
{!! Form::close() !!}
@endsection