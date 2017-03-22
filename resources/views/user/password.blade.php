<?php
use App\Lib\Frm;
?>
@extends('layouts.pageform',["title"=>__("Edit user profile")])
@section('formbody')
<?php 
/**
 * Edit password
 */
?>
{!! Form::open(["route"=>["user.savepassword"]]) !!}
<table class="form_table">

<?php
Frm::password("password", __("New password"), $errors, "", "");
Frm::password("passwordconf", __("Confirm password"), $errors, "", "");
Frm::footer("user.profile");
?>

</table>
@endsection