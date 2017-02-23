@extends('layouts.page',["title"=>__("login")])
@section('content')
{!! Form::open(["route"=>"register"]) !!}
<table class="login_form">
<tr>
	<td>
		{!! Form::label("name",__("Name")) !!}
	</td>
	<td>
		@if ($errors->has('name'))
			<div class="form_error">{{ $errors->first('name') }}</div>
		@endif 
		{!! Form::text("name",old("name"),["class"=>"login_element"]) !!}
	</td>
</tr>
<tr>
	<td>
		{!! Form::label("email",__("Email")) !!}
	</td>
	<td>
		@if ($errors->has('email'))
			<div class="form_error">{{ $errors->first('email') }}</div>
		@endif 
		{!! Form::text("email",old("email"),["class"=>"login_element"]) !!}
	</td>
</tr>
<tr>
	<td>
		{!! Form::label("password",__("Password")) !!}
	</td>
	<td>
		@if ($errors->has('password'))
			<div class="form_error">{{ $errors->first('password') }}</div>
		@endif 
		{!! Form::password("password",["class"=>"login_element"]) !!}
	</td>	
</tr>
<tr>
	<td>
		{!! Form::label("password_confirmation",__("Password confirmation")) !!}		
	</td>
	<td>
		@if ($errors->has('password_confirmation'))
			<div class="form_error">{{ $errors->first('password_confirmation') }}</div>
		@endif 
		{!! Form::password("password_confirmation",["class"=>"login_element"],["class"=>"login_element"]) !!}
	</td>
</tr>
<tr>
<td colspan='2'>
	<button type="submit" class="btn btn-primary">
    	{{ __("Register") }}
    </button>
</td>
</tr>
</table>
{!! form::close() !!}
@endsection

