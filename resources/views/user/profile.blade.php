@extends("layouts.pagemenu",["title"=>__("User profile")])
@section("pagebody")
<?php 
	\App\Vc\UserVC::profile($user);
?>
@endsection