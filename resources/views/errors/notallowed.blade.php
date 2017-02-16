@extends("pagemenu.layouts")
@section("pagebody")
<div class="error_text">
{{ __("Not allowed to") }} {{ $message }}
</div>
@endsection