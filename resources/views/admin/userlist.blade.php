<?php

use App\Vc\User\AllUserTable;

?>
@extends("layouts.pagemenu",["title"=>__("Users")]) @section("pagebody")
<div class="buttonBar">
				<a href='{{ route("admin.users.new") }}' class='buttonLink'><img
					src='/images/adduser.png'>{{ __("Add new user") }}</a>
			</div>
<?php 
    $l_list=new AllUserTable();
    $l_list->display();

?>
@endsection
