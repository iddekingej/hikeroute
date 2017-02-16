<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
/**
 * Handles uploading ,deleting, editing etc.. of hiking routes 
*/
class RoutesController extends Controller
{
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	private function displayError($p_message)
	{
		return View("errors.notallowd",["message"=>$p_message]);
	}
	
	
	/**
	 * Display input form for entering a new hiking route
	 * 
	 * @return View View with input form 
	 */
	
	function newRoute()
	{
	
		return View("routes.newupload",["title"=>"Post a new hiking route"
		                         ,"id"=>""
				                 ,"routeTitle"=>""
				                 ,"comment"=>""]);
	}

	/**
	 * Delete a route and return to the routes overwiew of the user.
	 * Is the user is not allowed to delete the route, than a error
	 * message is displayed
	 * 
	 * @param integer $p_id the ID of the route to delete
	 * @return Redirect|View  Redirect to route overview(if successfull) or a error message (when failed)
	 */
	
	function delRoute($p_id)
	{
		$l_route=\App\Map\Route::findOrFail($p_id);
		if(Gate::allows("edit-route",$l_route)){
			$l_route->delete();
			return Redirect::to("/routes/");				
		} else {
			return $this->displayError(__("delete this route"));
		}
	}
	
	function getRouteInfo(\App\Model\RouteFile $p_routeFile)
	{
		$l_gpxParser=new \App\Lib\GPXReader();
		$l_gpx=$l_gpxParser->parse($p_routeFile->gpxdata);
		return $l_gpx;
	}
	/**
	 * Display form for editing a route post.
	 * 
	 * @param integer $p_id Route ID, given as parameter.
	 * @return unknown
	 */
	
	function editRoute($p_id)
	{
		$l_route=\App\Model\Route::findOrFail($p_id);
		if(Gate::allows("edit-route",$l_route)){
			$l_gpx=$this->getRouteInfo($l_route->routeFile()->getResults());
			$l_data = [ 
					"title" => __("Edit route"),
					"id" => $l_route->id,
					"id_routefile"=>$l_route->id_routefile,
					"routeTitle" => $l_route->title,
					"comment" => $l_route->comment ,
					"routeLocation" =>$l_route->location,
					"info"=>$l_gpx->getInfo()
			];
			return View ( "routes.new", $l_data );
		} else {
			return $this->displayError(__("edit this route"));
		}
	}
	
	function updateGPX($p_id)
	{
		$l_route=\App\Model\Route::findOrFail($p_id);
		if(Gate::allows("edit-route",$l_route)){
			$l_data=["id"=>$p_id];
			return View("routes.upload",$l_data);
		}
	}
	
	function saveNewUpload(Request $p_request)
	{
		$l_rules = [
				"routefile" => [
						"required"
				]
		];
			
		$l_validator = Validator::make ( $p_request->all (), $l_rules );
		if ($l_validator->fails ()) {
			return Redirect::to ( "/routes/new/")->withErrors ( $l_validator )->withInput ( $p_request->all () );
		}
		$l_path=$p_request->file("routefile")->path();
		$l_content=file_get_contents($l_path);
		$l_routeFile=\App\Model\RouteFile::create(["gpxdata"=>$l_content]);
		$l_gpx=$this->getRouteInfo($l_routeFile);
		$l_locData=\App\Lib\AddressService::locationStringFromGPX($l_gpx->getStart());
		
		$l_data = [
				"title" => __("New route"),
				"id" => "",
				"id_routefile"=>$l_routeFile->id,
				"routeTitle" => "",
				"comment" => "",
				"info"=>$l_gpx->getInfo(),
				"routeLocation"=>$l_locData
		];
		return View ( "routes.new", $l_data );
	}
	
	function saveUploadGPX(Request $p_request)
	{
		$l_id=$p_request->input("id");
		$l_route=\App\Model\Route::findOrFail($l_id);
		if(Gate::allows("edit-route",$l_route)){
			$l_rules = [ 
					"routefile" => [ 
							"required" 
					] 
			];
			
			$l_validator = Validator::make ( $p_request->all (), $l_rules );
			if ($l_validator->fails ()) {
				return Redirect::to ( "/routes/updategpx/$l_id" )->withErrors ( $l_validator )->withInput ( $p_request->all () );
			}
			$l_path=$p_request->file("routefile")->path();
			$l_content=file_get_contents($l_path);
			$l_routeFile=$l_route->routeFile()->getResults();
			$l_routeFile->gpxdata=$l_content;
			$l_routeFile->save();
			return Redirect::to("/routes/display/$l_id");				
		} else {
			return $this->displayError(__("update route file"));
		}
	}
	
	/**
	 * Display a list of routes belonging to the current user
	 * 
	 * @return View View with list 
	 */
	function listRoutes()
	{
		return View("routes.list",["routes"=>\Auth::user()->routes()->orderBy("created_at","desc")->getResults()]);
	}
	
	/**
	 * Process data the after submitting a new route.
	 * This method validates data and stores data in the "route" table
	 * 
	 * @param Request $p_request request send back from form
	 * 
	 * @return Redirect  Redrict to next page
	 */
	function saveAddRoute(Request $p_request)
	{
		$l_rules=["routeTitle"=>["required"]];
		
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
			return Redirect::to("/routes/save/newupload")->withErrors($l_validator)->withInput($p_request->all());
		}
		
		\App\Model\Route::create(["id_user"=>\Auth::user()->id
				       ,"title"=>$p_request->input("routeTitle")
                       ,"comment"=>$p_request->input("comment")
					   ,"location"=>$p_request->input("routeLocation")
		               ,"id_routefile"=>$p_request->input("id_routefile")
				]);
		return Redirect::to("/routes/");		
	}
	
	/**
	 * After the user editted the route data, this method saves the route
	 * 
	 * @param Request $p_request Data send back by the route
	 * @return Redirect Redirect to route display
	 */
	
	function saveUpdateRoute(Request $p_request)
	{
		$l_rules=["routeTitle"=>["required"]];
		
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
			return Redirect::to("/routes/new")->withErrors($l_validator)->withInput($p_request->all());
		}
		$l_id=$p_request->input("id");
		$l_route=\App\Model\Route::findOrFail($l_id);
		$l_route->title=$p_request->input("routeTitle");
		$l_route->comment=$p_request->input("comment");
		$l_route->location=$p_request->input("routeLocation");
		$l_route->save();
		return Redirect::to("/routes/display/$l_id");
	}
}