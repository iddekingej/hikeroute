<?php
use App\Vc\RouteTracesVC;
?>
@extends("layouts.pagemenu",["title"=>__("User route traces")])
@section("pagebody")
<?php
RouteTracesVC::listTopMenu();
RouteTracesVC::traceListTable($traces, "traces.show");
?>
@endsection