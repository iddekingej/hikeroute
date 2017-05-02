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
use App\Models\Location;
use App\Models\RouteTraceTableCollection;
use App\Models\RouteTrace;
use App\Lib\GPXList;

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
        $l_gpx = $l_gpxParser->parse($p_routeFile->gpxdata);
        return $l_gpx;
    }

    /**
     * handle GPX file upload.
     * Checks if the file is readable, checks and parses the GPX file.
     * When the validation fails the upload form (with rout in p_errorDirect)
     * is displayed with an error message
     *
     * @param Request $p_request
     *            Upload request
     * @param String $p_errorRedirect
     *            Redirect address when upload fails
     * @param String $p_content
     *            Returns the content of the GPX file
     * @param String $p_gpx
     *            Parsed gpx data
     * @return Redirect|NULL When validation fails, a redirect is return
     *         otherwise a null is returned.
     */
    function getCheckRouteFile(Request $p_request, $p_errorRedirect, &$p_content, &$p_gpxInfo)
    {
        $l_path = $p_request->file("routefile")->path();
        $p_content = file_get_contents($l_path);
        
        $l_message = null;
        if ($p_content === false) {
            $l_message = __("Uploading routefile failed");
        } else {
            try {
                $l_gpxParser = new GPXReader();
                $p_gpxInfo = $l_gpxParser->parse($p_content);
            } catch (\Exception $l_e) {
                $l_message = __("Invalid gpx file:") . $l_e->getMessage();
            }
        }
        
        if ($l_message !== null) {
            return Redirect::to($p_errorRedirect)->withErrors([
                "routefile" => $l_message
            ])->withInput($p_request->all());
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
        return View("routes.list", [
            "routes" => \Auth::user()->routes()
                ->orderBy("created_at", "desc")
                ->getResults()
        ]);
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
    function delRoute(int $p_id)
    {
        $l_route = Route::findOrFail($p_id);
        
        if (Gate::allows("edit-route", $l_route)) {
            $l_route->deleteDepended();
            return Redirect::to("/routes/");
        } else {
            return $this->displayError(__("delete this route"));
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
        $l_traces = RouteTraceTableCollection::getByUser(\Auth::user());
        return View("routes.selecttrace", [
            "title" => __("Post a new hiking route"),
            "traces" => $l_traces,
            "id_route" => "",
            "next" => "routes.newdetails"
        ]);
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
    function newDetails(string $p_id)
    {
        $this->checkInteger($p_id);
        $l_routeTrace = RouteTrace::findOrFail($p_id);
        if (! $l_routeTrace->canRoute(\Auth::user())) {
            return $this->displayError(__("attach this route file to a route"));
        }
        $l_data = [
            "route"=>null,
            "routeTrace" => $l_routeTrace,
        
        ];
        
        return View("routes.form", $l_data);
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
            "routeTitle" => [
                "required"
            ],
            "id_routetrace" => [
                "required",
                "integer"
            ]
        ];
        
        $l_validator = Validator::make($p_request->all(), $l_rules);
        if ($l_validator->fails()) {
            return Redirect::to("/routes/newdetails/" . $p_request->input("id_routefile"))->withErrors($l_validator)->withInput($p_request->all());
        }
        $l_routeTrace = RouteTrace::findOrFail($p_request->input("id_routetrace"));
        if (! $l_routeTrace->canRoute(\Auth::user())) {
            return $this->displayError(__("attach this route file to a route"));
        }
        Route::create([
            "id_user" => \Auth::user()->id,
            "title" => $p_request->input("routeTitle"),
            "comment" => $p_request->input("comment"),
            "location" => $p_request->input("routeLocation"),
            "id_routetrace" => $l_routeTrace->id,
            "publish" => $p_request->input("publish") ? 1 : 0
        ]);
        return Redirect::to("/routes/");
    }

    // --------(edit route)----------------------------
    private function notAllowedToChangeRoute()
    {
        return $this->displayError(__("Not allowed to change this route"));
    }

    function traceEdit($p_id)
    {
        $l_route = Route::findOrFail($p_id);
        if (! $l_route->canEdit(\Auth::user())) {
            return $this->notAllowedToChangeRoute();
        }
        $l_traces = RouteTraceTableCollection::getByUser(\Auth::user());
        return View("routes.selecttrace", [            
            "traces" => $l_traces,
            "route" => $l_route            
        ]);
    }

    /**
     * When a new trace is selected for a route, update the information.
     *
     * @param int $p_id_route            
     * @param int $p_id            
     * @return \App\Http\Controllers\unknown|unknown
     */
    function traceUpdate($p_id_route, $p_id)
    {
        $this->checkInteger($p_id);
        $this->checkInteger($p_id);
        $l_route = Route::findOrFail($p_id_route);
        $l_routeTrace = RouteTrace::findOrFail($p_id);
        if (! $l_route->canEdit(\Auth::user())) {
            return $this->notAllowedToChangeRoute();
        }
        if (! $l_routeTrace->canRoute(\Auth::user())) {
            return $this->displayError(__("Not allowed to use this trace for a new route"));
        }
        $l_route->id_routetrace = $l_routeTrace->id;
        $l_route->save();
        return Redirect::route("display.overview", [
            "p_id" => $l_route->id
        ]);
    }

    /**
     * Displays a form for editing an existing route.
     *
     * @param integer $p_id
     *            Route ID.
     * @return unknown
     */
    function editRoute($p_id)
    {
        $this->checkInteger($p_id);
        $l_route = Route::findOrFail($p_id);
        $l_routeTrace = $l_route->routeTrace;
        if (Gate::allows("edit-route", $l_route)) {
            $l_data = [
                "route"=>$l_route,
                "routeTrace" => $l_routeTrace
            ];
            return View("routes.form", $l_data);
        } else {
            return $this->displayError(__("edit this route"));
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
            "routeTitle" => [
                "required"
            ]
        ];
        
        $l_validator = Validator::make($p_request->all(), $l_rules);
        if ($l_validator->fails()) {
            return Redirect::to("/routes/new")->withErrors($l_validator)->withInput($p_request->all());
        }
        $l_route = Route::findOrFail($l_id);
        $l_route->title = $p_request->input("routeTitle");
        $l_route->comment = $p_request->input("comment");
        $l_route->location = $p_request->input("routeLocation");
        $l_route->publish = $p_request->input("publish") ? 1 : 0;
        $l_route->save();
        return Redirect::route("display.overview",["id"=>$l_id]);
        
    }
}