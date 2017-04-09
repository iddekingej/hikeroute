<?php
use App\Lib\Page;
?>
@extends('layouts.page',["title"=>$title])
@section('content')
<table class="leftmenu_table">
	<tr>
		<td class='leftmenu'>
<?php
Page::menuGroup(__("Profile"));
?>
<div class="leftmenu_item_con">
				<a class="leftmenu_item" href="{{ route('logout') }}"
					onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					{{ __("Logout")}} </a>
			</div>
<?php
Page::menuItem("user.profile", __("Profile"));
if (\Auth::user() && \Auth::user()->isAdmin()) {
    Page::menuGroup(__("Administration"));
    Page::menuItem("admin.users", __("Users"));
}
Page::menuGroup(__("Routes"));
Page::menuItem("traces.list", __("Route traces"));
Page::menuItem("routes", __("Routes"));
Page::menuItem("start", __("Published routes"));
?>
@yield("menu")
<form id="logout-form" action="{{ route('logout') }}" method="POST"
				style="display: none;">{{ csrf_field() }}</form>
		</td>
		<td class="pagecontent">@yield("pagebody")</td>

</table>
@endsection
