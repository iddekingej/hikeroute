<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield("header")
<title>{{ $title }}</title>
<link href="/css/main.css" rel="stylesheet" />
<script type='text/javascript' src='/js/core.js' ></script>
<script type='text/javascript' src='/js/main.js' ></script>
<script type='text/javascript'>
window.Laravel = {!! json_encode([
		'csrfToken' => csrf_token(),
]) !!};
</script>


</head>
<body>
<div class="apptitle" >
	<table class="apptitle_table">
		<tr>
			<td class="apptitle_title">{{ __("Hiking routes") }}</td>
			<td class="apptitle_name">
				@if(!\Auth::user())|				
					<a class="buttonLink" href="{{ route('login') }}">{{ __("Login") }}</a>&nbsp;
					<a class="buttonLink" href="{{ route('register') }}">{{ __("Register") }}</a>
				@else
					<a href="{{ Route('user.profile') }}"  class="apptitle_name">{{ \Auth::user()?\Auth::user()->name:"Guest" }}</a>					
				@endif
			</td>
		</tr>
	</table>
</div>
        @yield('content')
</body>