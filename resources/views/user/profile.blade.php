@extends("layouts.pagemenu",["title"=>__("User profile")])
@section("pagebody")
<div>
<table>
<tr>
	<td>{{ __("Nick name") }}</td>
	<td>{{ $user->name }} </td>
</tr>	
<tr>
	<td>{{ __("First name") }}</td>
	<td>{{ $user->firstname }}</td>
</tr>
<tr>
	<td>{{ __("Last name") }}</td>
	<td>{{ $user->lastname }}</td>
</tr>
<tr>
	<td>{{ __("Email adres") }}</td>
	<td>{{ $user->email }} </td>
</tr>
</table>
<?php \App\Lib\Page::editLink("user.editprofile",[],__("Edit profile")) ?>
</div>
@endsection