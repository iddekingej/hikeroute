<?php
use App\Lib\Frm;
?>
@extends('layouts.pageform',["title"=>__("Upload image")])

@section("formbody")
<?php 
Form::open(["route"=>"images.save","enctype"=>"multipart/form-data"]);
Form::hidden("id",$route->id) 
?> 
<table class="form_table">
<?php 
Frm::file("image",__("Image"),$errors);
Frm::submit(Route("display.overview",["id"=>$route->id]));
?>
</table>
{!! 
Form::close() 
!!}
@endsection