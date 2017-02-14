@extends('layouts.page')
@section('content')
<table class="leftmenu_table">
<tr>
<td class='leftmenu'>
<b>Name:</b>{{\Auth::user()->name}}<br/>
<b>Email:</b>{{\Auth::user()->email}}<br/>
<a class="buttonLink" href="{{ route('logout') }}"
   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
>
Logout
</a><br/>
@if(\Auth::user() && \Auth::user()->isAdmin())
<a class="buttonLink" href='{{ route("admin.users") }} '>Users</a><br/>
@endif
<a class="buttonLink" href='{{ route("routes") }} '>Routes</a><br/>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</td>
<td>
@yield("pagebody")
</td>
</table>
@endsection