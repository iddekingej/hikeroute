<?php
declare(exact_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RouteTraceTableCollection;

class TracesController extends Controller
{
	function list()
	{
		$l_traces=RouteTraceTableCollection::getByUser(\Auth::user());
		return View("traces.list",["traces"=>$l_traces]);
	}
}
