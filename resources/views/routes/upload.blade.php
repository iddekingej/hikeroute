<?php
use App\Lib\Frm;
?>
@extends('layouts.pageform',["title"=>__("Upload new GPX file to
existing route")]) @section('formbody') {!!
Form::open(["route"=>"routes.save.uploadgpx","enctype"=>"multipart/form-data"])
!!} {!! Form::hidden("id",$id) !!}

<table class="form_table">
<?php 
Frm::file("routeFile",__("GPX file"),$errors);
?>
	<tr>
		<td colspan='2' class="form_submitCell">{!! Form::submit(__("Save"))
			!!}
			<button type='button'
				onclick='window.location="{{ Route("display.trace",["id"=>$id]) }}"'>Cancel</button>
		</td>
	</tr>
</table>
{!! Form::close() !!} @endsection
