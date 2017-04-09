@extends('layouts.pageform',["title"=>$title]) @section('formbody') {!!
Form::open(["route"=>["admin.users.save.$cmd"],"autocomplete"=>"off"])
!!} {!! Form::hidden("id",$id) !!}
<input type='text' style='display: none' />
<input type='password' style='display: none' />
<table class="form_table">
<?php
\App\Lib\Frm::text("name", __("Nick name"), $name, $errors);
\App\Lib\Frm::text("firstname", __("First name"), $firstname, $errors);
\App\Lib\Frm::text("lastname", __("Last name"), $lastname, $errors);
\App\Lib\Frm::text("email", __("Email"), $email, $errors);
\App\Lib\Frm::checkbox("enabled", __("Account enabled"), $enabled, []);
if ($id != "") {
    \App\Lib\Frm::checkbox("resetpassword", __("Reset password ?"), false, [
        "onclick" => "gui.displayId('password',this.checked);gui.displayId('passwordconf',this.checked)"
    ]);
}
\App\Lib\Frm::password("password", "Password", $errors, "password", "display:" . ($id == "" ? "" : "none"));
\App\Lib\Frm::password("passwordconf", "Password confirmation", $errors, "passwordconf", "display:" . ($id == "" ? "" : "none"));
?>
<tr>
		<td colspan='2' class='form_section'>Rights</td>
	</tr>
	<!-- Print selection of rights -->
@foreach($rights as $l_right)
<?php
\App\Lib\Frm::checkbox("right_" . $l_right[0]->id, $l_right[0]->description, $l_right[1]);
?>
@endforeach
<tr>
		<td colspan='2' class="form_submitCell">{!! Form::submit("Save") !!}
			<button type='button'
				onclick='window.location="{{ Route("admin.users") }}"'>{{
				__("Cancel") }}</button>
		</td>
	</tr>

</table>
{!! Form::close() !!} @endsection
