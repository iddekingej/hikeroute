@extends('layouts.page')
@section('content')
<table class="leftmenu_table">
<tr>
<td class='leftmenu'>
<div class="leftmenu_item_con">
<a class="leftmenu_item" href="{{ route('logout') }}"
   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
>
Logout
</a>
</div>

@if(\Auth::user() && \Auth::user()->isAdmin())
<div class="leftmenu_item_con">
<a class="leftmenu_item" href='{{ route("admin.users") }} '>Users</a>
</div>
@endif
<div class="leftmenu_item_con">
<a class="leftmenu_item" href='{{ route("routes") }} '>Routes</a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</td>
<td class="pagecontent">
@yield("pagebody")
</td>
</table>
@endsection