<?php
use App\Lib\Frm;
?>
@extends('layouts.pageform',["title"=>__("Upload new GPX file")])
@section('formbody') {!!
Form::open(["route"=>"traces.save","enctype"=>"multipart/form-data"])
!!}
<table class="form_table">
	<?php Frm::file("routefile",__("GPX file"),$errors);?>

	<tr>
		<td colspan='2' class="form_submitCell">{!! Form::submit(__("Save"))
			!!}
			<button type='button'
				onclick='window.location="{{ Route("traces.list") }}"'>Cancel</button>
		</td>
	</tr>
</table>
{!! Form::close() !!} @endsection
