<?php
use App\Vc\Trace\TraceTable;
?>
@extends('layouts.pageform',["title"=>__("Upload new GPX file")])
@section('formbody')
<div class="page_hint">{{ __("Please, select first a previous uploaded
	route trace")}}</div>
<?php
$l_traceTable=new TraceTable($traces,"routes.trace.update",["id_route"=>$route->id]);
$l_traceTable->display();
?>
@endsection