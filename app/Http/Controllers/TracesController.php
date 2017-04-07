<?php
declare(exact_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RouteTraceTableCollection;
use App\Models\RouteTrace;

class TracesController extends Controller
{
	function list()
	{
		$l_traces=RouteTraceTableCollection::getByUser(\Auth::user());
		return View("traces.list",["traces"=>$l_traces]);
	}
	
	function show($p_id)
	{
		$this->checkInteger($p_id);
		$l_trace=RouteTrace::findOrFail($p_id);
		if(!$l_trace->canViewTrace(\Auth::user())){
			return $this->displayError(__("to view this route trace"));
		}
		return View("traces.show",["routeTrace"=>$l_trace]);
	}
	
	function download($p_id)
	{
		$this->checkInteger($p_id);
		$l_trace=RouteTrace::findOrFail($p_id);
		if($l_trace->canViewTrace(\Auth::user())){
			return response($l_trace->routeFile()->gpxdata)
			->header("Content-Description","File Transfer")
			->header("Content-Type","application/gpx+xml")
			->header("Content-Disposition","attachment; filename='route.gpx'");
		}
		return $this->displayError(__("to view this route trace"));
	}
}
