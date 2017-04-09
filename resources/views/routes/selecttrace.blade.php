<?php
use App\Vc\RouteTracesVC;
?>
@extends('layouts.pageform',["title"=>__("Upload new GPX file")])
@section('formbody')
<div class="page_hint">{{ __("Please, select first a previous uploaded
	route trace")}}</div>
<?php
RouteTracesVC::traceListTable($traces, $next, [
    "p_id_route" => $id_route
]);
?>
@endsection