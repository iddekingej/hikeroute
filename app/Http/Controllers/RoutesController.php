<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\View\View;
use App\Models\Route;
use App\Lib\GPXReader;
use App\Models\RouteFile;
use App\Models\Location;
use App\Models\RouteTrace;
use App\Lib\GPXList;
use XMLView\View\ResourceView;

/**
 * Handles uploading ,deleting, editing etc..
 * of hiking routes
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
     * *
     * Parse route gpx file
     *
     * @param RouteFile $p_routeFile
     *            Record from the route file, with the gpx data
     * @return \App\Lib\GPXList Information from the gpxdata
     */
    function getRouteInfo(RouteFile $p_routeFile): GPXList
    {
        $l_gpxParser = new GPXReader();
        return $l_gpxParser->parse($p_routeFile->gpxdata);
    }

    /**
     * Displays a list of routes belonging to the current user
     *
     * @return View View with list of routes
     */
    function listRoutes()
    {
        return new ResourceView("route/List.xml",["routes"=> \Auth::user()->routes()
            ->orderBy("created_at", "desc")
            ->getResults()]);
    }

    /**
     * Deletes a route and returns to the users routes overview.
     * Is the user is not allowed to delete the route, an error
     * message is displayed.
     *
     * @param integer $p_id
     *            the ID of the route to delete
     * @return Redirect|View Redirect to route overview(if successful) or a error message (when failed)
     */
    function delRoute(Route $p_route)
    {        
        
        if ($p_route->canEdit(\Auth::user())) {
            $p_route->deleteDepended();
            return Redirect::Route("routes");
        } else {
            return $this->displayError(__("Not allowed to delete this route"));
        }
    }

    // --------(new route)----------------------------
    
    /**
     * When entering a new route, first select a previous uploaded route
     *
     * @return View View with input form
     */
    function newRoute()
    {
        return new ResourceView("trace/SelectTrace.xml",["next"=>"routes.newdetails","id_route"=>""]);       
    }

    /**
     * When add a new route ,first the route is uploaded.
     * After
     * the route file is inserted in the database successful
     * , this method is called and a form for entering route is displayed.
     *
     * @param integer $p_id
     *            ID of route file added in the previous step.
     * @return unknown
     */
    function newDetails(RouteTrace $p_routeTrace)
    {

        if (! $p_routeTrace->canRoute(\Auth::user())) {
            return $this->displayError(__("Not allowed to attach this route file to a route"));
        }
        return new ResourceView("route/Edit.xml",[
            "route"=>null,
            "routeTrace" => $p_routeTrace,
            
        ]);
    }

    /**
     * After a route is uploaded, a form with route details is displayed.
     * When the form is submitted, this method insert the data into the database.
     *
     * @param Request $p_request
     *            request send back from form
     *            
     * @return Redirect Redirect to next page
     */
    function saveAddRoute(Request $p_request)
    {
        $l_rules = [
            "title" => [
                "required"
            ],
            "id_routetrace" => [
                "required",
                "integer"
            ]
        ];
        $l_id_routeTrace=$p_request->input("id_routetrace");
        $l_validator = Validator::make($p_request->all(), $l_rules);
        if ($l_validator->fails()) {
            return Redirect::route("routes.newdetails",["id_routetrace"=>$l_id_routeTrace])->withErrors($l_validator)->withInput($p_request->all());
        }
        $l_routeTrace = RouteTrace::findOrFail($l_id_routeTrace);
        if (! $l_routeTrace->canRoute(\Auth::user())) {
            return $this->displayError(__("Not allowed to attach this route trace to a route"));
        }
        $l_route=Route::create([
            "id_user" => \Auth::user()->id,
            "title" => $p_request->input("title"),
            "comment" => $p_request->input("comment"),
            "location" => $p_request->input("location"),
            "id_routetrace" => $l_routeTrace->id,
            "publish" => $p_request->input("publish") ? 1 : 0
        ]);
        return Redirect::route("display.overview",["id"=>$l_route->id]);
    }

    // --------(edit route)----------------------------
    private function notAllowedToChangeRoute()
    {
        return $this->displayError(__("Not allowed to change this route"));
    }

    function traceEdit(Route $p_route)
    {        
        if (! $p_route->canEdit(\Auth::user())) {
            return $this->notAllowedToChangeRoute();
        }        
        return new ResourceView("trace/SelectTrace.xml", [                        
            "id_route" => $p_route->id,  
            "next"=>"routes.trace.update"
        ]);
    }

    /**
     * When a new trace is selected for a route, update the information.
     *
     * @param int $p_id_route            
     * @param int $p_id            
     * @return \App\Http\Controllers\unknown|unknown
     */
    function traceUpdate(Route $p_route, RouteTrace $p_routeTrace)
    {        
        if (! $p_route->canEdit(\Auth::user())) {
            return $this->notAllowedToChangeRoute();
        }
        if (! $p_routeTrace->canRoute(\Auth::user())) {
            return $this->displayError(__("Not allowed to use this trace for a new route"));
        }
        $p_route->id_routetrace = $p_routeTrace->id;
        $p_route->save();
        return Redirect::route("display.trace", ["p_id" => $p_route->id]);
    }

    /**
     * Displays a form for editing an existing route.
     *
     * @param integer $p_id
     *            Route ID.
     * @return unknown
     */
    function editRoute(Route $p_route)
    {               
        if($p_route->canEdit(\Auth::user())){
            return new ResourceView("route/Edit.xml",["route"=>$p_route]);
        } else {
            return $this->displayError(__("Not allowed to edit this route"));
        }
    }

    /**
     * After the user edited an existing route, this method
     * saves the information in the database
     *
     * @param Request $p_request
     *            Data send back by the route
     * @return Redirect Redirect to route display
     */
    function saveUpdateRoute(Request $p_request)
    {
        $l_id = $p_request->input("id");
        $this->checkInteger($l_id);
        $l_rules = [
            "title" => [
                "required"
            ]
        ];
        
        $l_validator = Validator::make($p_request->all(), $l_rules);
        if ($l_validator->fails()) {
            return Redirect::route("routes.edit",["id"=>$l_id])->withErrors($l_validator)->withInput($p_request->all());
        }
        $l_route = Route::findOrFail($l_id);
        $l_route->title = $p_request->input("title");
        $l_route->comment = $p_request->input("comment");
        $l_route->location = $p_request->input("location");
        $l_route->publish = $p_request->input("publish") ? 1 : 0;
        $l_route->save();
        return Redirect::route("display.overview",["id"=>$l_id]);
        
    }
}