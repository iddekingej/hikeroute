<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Route;
use App\Lib\GPXReader;
use App\Models\RouteFile;
use App\Lib\AddressService;
/**
 * Handles uploading ,deleting, editing etc.. of hiking routes 
*/

class RoutesController extends Controller
{
/**
 * Construct RoutesController
 * 
 * Auth middelware: This controller can only be used when user is logged in
 */
	
	public function __construct()
	{
		$this->middleware('auth');
	}
	
/**
 * Displays and error page
 * 
 * @param String $p_message Message to display
 * @return unknown
 */
	private function displayError($p_message)
	{
		return View("errors.notallowed",["message"=>$p_message]);
	}
	
	/***
	 * Parse route gpx file
	 *
	 * @param RouteFile $p_routeFile Record from the route file, with the gpx data
	 * @return \App\Lib\GPXList Information from the gpxdata
	 */
	
	function getRouteInfo(RouteFile $p_routeFile)
	{
		$l_gpxParser=new GPXReader();
		$l_gpx=$l_gpxParser->parse($p_routeFile->gpxdata);
		return $l_gpx;
	}
	
	/**
	 * handle GPX file upload.
	 * Checks if the file is readable, checks and parses the GPX file.
	 * When the validation fails the upload form (with rout in p_errorDirect)
	 * is displayed with an error message
	 *
	 * @param Request $p_request         Upload request
	 * @param String  $p_errorRedirect   Redirect address when upload fails
	 * @param String  $p_content         Returns the content of the GPX file
	 * @param String  $p_gpx             Parsed gpx data
	 * @return Redirect|NULL             When validation fails, a redirect is return
	 *                                   otherwise a null is returned.
	 */
	
	function getCheckRouteFile(Request $p_request,$p_errorRedirect,&$p_content,&$p_gpxInfo)
	{
		$l_path=$p_request->file("routefile")->path();
		$p_content=file_get_contents($l_path);
	
		$l_message=null;
		if($p_content===false){
			$l_message=__("Uploading routefile failed");
		} else {
			try{
				$l_gpxParser=new GPXReader();
				$p_gpxInfo=$l_gpxParser->parse($p_content);
			} catch(\Exception $l_e){
				$l_message="Invalid gpx file:".$l_e->getMessage();
			}
		}
	
		if($l_message !== null){
			return Redirect::to ( $p_errorRedirect )
			->withErrors ( ["routefile"=>$l_message])
			->withInput ( $p_request->all () );
		}
	
		return null;
	}
	
	/**
	 * Displays a list of routes belonging to the current user
	 *
	 * @return View View with list of routes
	 */
	function listRoutes()
	{
		return View("routes.list",["routes"=>\Auth::user()->routes()->orderBy("created_at","desc")->getResults()]);
	}
	
	
	/**
	 * Deletes a route and returns to the users routes overview.
	 * Is the user is not allowed to delete the route, an error
	 * message is displayed.
	 *
	 * @param integer $p_id the ID of the route to delete
	 * @return Redirect|View  Redirect to route overview(if successful) or a error message (when failed)
	 */
	
	function delRoute($p_id)
	{
		$l_route=Route::findOrFail($p_id);

		if(Gate::allows("edit-route",$l_route)){
			$l_routeFile=$l_route->routeFile()->getResults();;
			$l_route->delete();
			$l_routeFile->delete();
			return Redirect::to("/routes/");
		} else {
			return $this->displayError(__("delete this route"));
		}
	}
	
	//--------(new route)----------------------------
	
	/**
	 * Displays an input form for entering a new hiking route
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
	 * When adding a new route, first a gpx file is uploaded.
	 * This method saves the route. After the upload a form is 
	 * displayed for entering some information about the hiking route
	 * this information is saved by the method @see RoutesController@saveAddRoute
	 * 
	 * @param Request $p_request
	 * @return Redirect|View  
	 */
	
	function saveNewUpload(Request $p_request)
	{
		$l_rules = [
				"routefile" => [
						"required"
				]
		];
			
		$l_validator = Validator::make ( $p_request->all (), $l_rules );
		if ($l_validator->fails ()) {
			return Redirect::to ( "/routes/new/")
			       ->withErrors ( $l_validator )
			        ->withInput ( $p_request->all () );
		}
		
		$l_content=null;
		$l_result=$this->getCheckRouteFile($p_request, "/routes/new/", $l_content,$l_gpxInfo);
		if($l_result != null){
			return $l_result;
		}
		
		
		$l_routeFile=RouteFile::create([
				"gpxdata"=>$l_content
		,		"id_user"=>\Auth::user()->id
		,       "startdate"=>$l_gpxInfo->getStart()->getDatePart()							
		]);
		
		return Redirect::to("/routes/newdetails/".$l_routeFile->id);
		
	}
	/**
	 * When add a new route ,first the route is uploaded. After
	 * the route file is inserted in the database successful 
	 * , this method is called and a form for entering route is displayed.
	 * 
	 * @param integer $p_id  ID of route file added in the previous step.
	 * @return unknown
	 */
	function newDetails($p_id)
	{
		$this->checkInteger($p_id);
		$l_routeFile=RouteFile::findOrFail($p_id);		
		if($l_routeFile->id_user != \Auth::user()->id){
			return $this->displayError(__("attach this route file to a route"));
		}
		
		if($l_routeFile->route()->getResults()){
			
			return $this->displayError(__("route file already attached to route"));
		}
		$l_gpxList=$this->getRouteInfo($l_routeFile);
		$l_locData=AddressService::locationStringFromGPX($l_gpxList->getStart());
		$l_data = [
				"title" => __("New route"),
				"id" => "",
				"id_routefile"=>$l_routeFile->id,
				"routeTitle" => $l_locData,
				"comment" => "",
				"info"=>$l_gpxList->getInfo(),
				"routeLocation"=>$l_locData,
				"publish"=>false
				
		];
		
		return View ( "routes.form", $l_data );
	}
	
	/**
	 * After a route is uploaded, a form with  route details is displayed.
	 * When the form is submitted, this method insert the data into the database.
	 *
	 * @param Request $p_request request send back from form
	 *
	 * @return Redirect  Redirect to next page
	 */
	function saveAddRoute(Request $p_request)
	{
		$l_id_routeFile=$p_request->input("id_routefile");
		$this->checkInteger($l_id_routeFile);
		$l_rules=["routeTitle"=>["required"]];
	
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
			return Redirect::to("/routes/newdetails/".$p_request->input("id_routefile"))
			->withErrors($l_validator)
			->withInput($p_request->all());
		}
	
		$l_routeFile=RouteFile::findOrFail($l_id_routeFile); //TODO: check if file belong to user!
		$l_gpxList=$this->getRouteInfo($l_routeFile);
		$l_info=$l_gpxList->getInfo();
			
		Route::create(["id_user"=>\Auth::user()->id
				,"title"=>$p_request->input("routeTitle")
				,"comment"=>$p_request->input("comment")
				,"location"=>$p_request->input("routeLocation")
				,"id_routefile"=>$l_id_routeFile
				,"publish"=>$p_request->input("publish")?1:0
				,"minlon"=>$l_info->minLon
				,"maxlon"=>$l_info->maxLon
				,"minlat"=>$l_info->minLat
				,"maxlat"=>$l_info->maxLat
		
		]);
		return Redirect::to("/routes/");
	}
	
	//--------(edit route)----------------------------
	
	/**
	 * When selecting "Uploading new GPX file" to an existing route
	 * 1) This method displays a upload form, then...
	 * 2) @see RoutesController::saveUploadGPX saves the gpx.
	 * 
	 * @param integer $p_id id of the selected hiking route
	 * @return unknown
	 */
	
	function uploadGPX($p_id)
	{
		$l_route=Route::findOrFail($p_id);
		if(Gate::allows("edit-route",$l_route)){
			$l_data=["id"=>$p_id];
			return View("routes.upload",$l_data);
		}
	}
	
	
	/**
	 * This method is called when a new GPX is uploaded for 
	 * an existing GPX 
	 * 
	 * @param Request $p_request
	 * @return Redirect
	 */
	function saveUploadGPX(Request $p_request)
	{
		$l_id=$p_request->input("id");
		$l_route=Route::findOrFail($l_id);
		if(Gate::allows("edit-route",$l_route)){
			
			//validate request
			$l_rules = [ 
					"routefile" => [ 
							"required" 
					] 
			];
			
			$l_validator = Validator::make ( $p_request->all (), $l_rules );
			if ($l_validator->fails ()) {
				return Redirect::to ( "/routes/updategpx/$l_id" )
						->withErrors ( $l_validator )
						->withInput ( $p_request->all () );
			}
			//get and check the route file
			$l_content=null;
			$l_result=$this->getCheckRouteFile($p_request, "/routes/updategpx/$l_id", $l_content,$l_gpxList);
			if($l_result != null){
				return $l_result;
			}
			
			$l_routeFile=$l_route->routeFile()->getResults();
			$l_routeFile->gpxdata=$l_content;
			$l_routeFile->save();
			$l_route=$l_routeFile->route()->getResults();
			$l_gpxInfo=$l_gpxList->getInfo();
			$l_route->minlon=$l_gpxInfo->minLon;
			$l_route->maxlon=$l_gpxInfo->maxLon;
			$l_route->minlat=$l_gpxInfo->minLat;
			$l_route->maxlat=$l_gpxInfo->maxLat;
			$l_route->save();
			return Redirect::to("/routes/display/$l_id");				
		} else {
			return $this->displayError(__("update route file"));
		}
	}
		
	/**
	 * Displays a form for editing an existing route.
	 *
	 * @param integer $p_id Route ID.
	 * @return unknown
	 */
	
	function editRoute($p_id)
	{
		$this->checkInteger($p_id);
		$l_route=Route::findOrFail($p_id);
		if(Gate::allows("edit-route",$l_route)){
			$l_gpx=$this->getRouteInfo($l_route->routeFile()->getResults());
			$l_data = [
					"title" => __("Edit route"),
					"id" => $l_route->id,
					"id_routefile"=>$l_route->id_routefile,
					"routeTitle" => $l_route->title,
					"comment" => $l_route->comment ,
					"routeLocation" =>$l_route->location,
					"info"=>$l_gpx->getInfo(),
					"publish"=>$l_route->publish
			];
			return View ( "routes.form", $l_data );
		} else {
			return $this->displayError(__("edit this route"));
		}
	}

	/**
	 * After the user edited an existing route, this method 
	 * saves the information in the database
	 *
	 * @param Request $p_request Data send back by the route
	 * @return Redirect Redirect to route display
	 */
	
	function saveUpdateRoute(Request $p_request)
	{
		$l_id=$p_request->input("id");
		$this->checkInteger($l_id);
		$l_rules=["routeTitle"=>["required"]];
	
		$l_validator=Validator::make($p_request->all(),$l_rules);
		if($l_validator->fails()){
			return Redirect::to("/routes/new")->withErrors($l_validator)->withInput($p_request->all());
		}
		$l_route=Route::findOrFail($l_id);
		$l_route->title=$p_request->input("routeTitle");
		$l_route->comment=$p_request->input("comment");
		$l_route->location=$p_request->input("routeLocation");
		$l_route->publish=$p_request->input("publish")?1:0;
		$l_route->save();
		return Redirect::to("/routes/display/$l_id");

	}
	

}