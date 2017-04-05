<?php
use App\Vc\RouteTracesVC;
?>
@extends("layouts.pagemenu",["title"=>__("User route traces")])
@section("pagebody")
<?php 
	RouteTracesVC::traceListHeader();
	foreach($traces as $l_trace)
	{
		RouteTracesVC::traceListRow($l_trace);
	}
	RouteTracesVC::traceListFooter();
?>
@endsection