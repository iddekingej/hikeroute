@extends('layouts.pageform',["title"=>__("login")])

@section('formbody')
<div class="login_form">
{!! Form::open(["route"=>"login"]) !!}
<div class="login_label">{!! Form::label("email",__("E-mail")) !!}</div>
@if ($errors->has('email'))
	<div class="form_errror">{{ $errors->first('email') }}</div>
@endif 
<div>{!! Form::text("email",old("email"),["class"=>"login_element"]) !!} </div>
<div class="login_label">{!! Form::label("password",__("Password")) !!}</div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
<div>{!! Form::password("password",["class"=>"login_element"]) !!}</div>
<div class="login_label">{!! Form::label("remember",__("Remember me?")) !!} {!! Form::checkbox("remember",old('remember'))!!}</div>
<div>
<button type="submit" class="btn btn-primary">{{ __("Login") }}</button>
</div>
{!! Form::close() !!}
<a class="btn btn-link" href="{{ route('password.request') }}">
	{{ __("Forgot Your Password?") }}
</a>
</div>	
@endsection
