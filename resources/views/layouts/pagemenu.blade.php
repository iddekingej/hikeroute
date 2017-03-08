@extends('layouts.page',["title"=>$title])
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
{{ \App\Lib\Page::menuItem("user.profile",__("Profile")) }}

@if(\Auth::user() && \Auth::user()->isAdmin())
{{ \App\Lib\Page::menuItem("admin.users",__("Users")) }}
@endif
{{ \App\Lib\Page::menuItem("start",__("Published routes")) }}
{{ \App\Lib\Page::menuItem("routes",__("Routes")) }}
@yield("menu")
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</td>
<td class="pagecontent">
@yield("pagebody")
</td>
</table>
@endsection