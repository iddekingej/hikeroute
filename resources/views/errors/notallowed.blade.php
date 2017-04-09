@extends("layouts.page",["title"=>__("Error")]) @section("content")
<div class="error_text">{{ __("Not allowed to:") }} {{ $message }}</div>
@endsection
