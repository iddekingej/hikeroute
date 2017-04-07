<?php
declare(exact_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RouteTraceTableCollection;
use App\Models\RouteTrace;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Validator;

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
	
	function del($p_id)
	{
		$this->checkInteger($p_id);
		$l_trace=RouteTrace::findOrFail($p_id);
		if($l_trace->hasRoutes()){
			return $this->displayError(__("to delete this trace, the route trace is used in a route"));
		};
		if(!$l_trace->canDelete(\Auth::user())){
			return $this->displayError(__("to delete this route trace"));
		}
		$l_trace->deleteDepend();
		return Redirect::route("traces.list");
	}
	
	function upload()
	{
		return View("traces.upload");	
	}
	
	
	/**
	 * When uploading a net GPX this routine saves the file
	 * @param Request $p_request
	 * @return Redirect|View
	 */
	
	function save(Request $p_request)
	{
		$l_rules = [
				"routefile" => [
						"required","file"
				]
		];
		
		$l_validator = Validator::make($p_request->all(), $l_rules);
		
		if ($l_validator->fails ()) {
			return Redirect::route("traces.upload")
			->withErrors($l_validator)
			->withInput($p_request->all());
		}
		
		try{
			$l_path = $p_request->file("routefile")->path();
			$l_content = file_get_contents($l_path);
			$l_routeTrace = RouteTraceTableCollection::addGpxFile($l_content);
		}catch(Exception $l_e){
			return Redirect::route("traces.upload" )
			       ->withErrors([
					"routefile"=>$l_e->getMessage()
			        ])->withInput($p_request->all());
			
		}
		return Redirect::route("traces.list");
		
	}
}
