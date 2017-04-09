@extends('layouts.page') @section('content')
<div class="form_body">
	<div class="form_container">
		<div class="form_title">{{$title}}</div>
		@yield("formbody")
	</div>
</div>
@endsection
