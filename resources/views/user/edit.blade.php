@extends('layouts.pageform',["title"=>__("Edit user profile")])
@section('formbody')
<?php 
/**
 * Edit profile
 */
?>
{!! Form::open(["route"=>["user.saveprofile"]]) !!}
<table class="form_table">
<?php 
\App\Lib\Frm::text("name", __("Nick name"), $user->name, $errors);
\App\Lib\Frm::text("firstname", __("First name"), $user->firstname, $errors);
\App\Lib\Frm::text("lastname", __("Last name"), $user->lastname, $errors);
\App\Lib\Frm::text("email",__("Email"),$user->email,$errors);
?>
<tr>
<td colspan='2' class="form_submitCell">
{!! Form::submit(__("Save")) !!}
<button type='button' onclick='window.location="{{ Route("user.profile") }}"'>{{ __("Cancel") }}</button>
</td>
</tr>
</table>
{!! Form::close() !!}

@endsection