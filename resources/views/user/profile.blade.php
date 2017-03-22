@extends("layouts.pagemenu",["title"=>__("User profile")])
@section("pagebody")
<div>
<div class="form_title">{{ __("Profile") }}</div>
<table>
<tr>
	<td class="profile_label">{{ __("Nick name") }}</td>
	<td class="profile_value">{{ $user->name }} </td>
</tr>	
<tr>
	<td class="profile_label">{{ __("First name") }}</td>
	<td class="profile_value">{{ $user->firstname }}</td>
</tr>
<tr>
	<td class="profile_label">{{ __("Last name") }}</td>
	<td class="profile_value">{{ $user->lastname }}</td>
</tr>
<tr>
	<td class="profile_label">{{ __("Email adres") }}</td>
	<td class="profile_value">{{ $user->email }} </td>
</tr>
</table>
<?php \App\Lib\Page::editLink("user.editprofile",[],__("Edit profile")) ?><br \>
<?php \App\Lib\Page::editLink("user.editpassword",[],__("Edit password")) ?>
</div>
@endsection