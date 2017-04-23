<?php
use App\Vc\Route\RouteTable;
?>
@extends("layouts.pagemenu",["title"=>__("User routes")])
@section("pagebody")
<div class="buttonBar">
	<a href='{{ route("routes.new") }}' class='buttonLink'> <img
		src='/images/adduser.png'>{{ __("Add new route") }}
	</a>
</div>
<?php 
    $l_tab=new RouteTable($routes);
    $l_tab->display();

?>
@endsection
