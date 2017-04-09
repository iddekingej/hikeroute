@extends('layouts.page',["title"=>__("login")]) @section('content')

<div class="login_form">
	{!! Form::open(["route"=>"login"]) !!}
	<div class="login_label">{!! Form::label("email",__("E-mail")) !!}</div>
	@if ($errors->has('email'))
	<div class="form_error">{{ $errors->first('email') }}</div>
	@endif
	<div>{!! Form::text("email",old("email"),["class"=>"login_element"])
		!!}</div>
	<div class="login_label">{!! Form::label("password",__("Password")) !!}</div>
	@if ($errors->has('password')) <span class="help-block"> <strong>{{
			$errors->first('password') }}</strong>
	</span> @endif
	<div>{!! Form::password("password",["class"=>"login_element"]) !!}</div>
	<div class="login_label">{!! Form::label("remember",__("Remember me?"))
		!!} {!! Form::checkbox("remember",old('remember'))!!}</div>
	<div>
		<br />
		<button type="submit" class="login_buttom">{{ __("Login") }}</button>
	</div>
	{!! Form::close() !!}

</div>
@endsection
