<?php 
/**
 * URLs for posting and editing hiking routes
 */
Route::group([
    "middleware" => "auth",
    "prefix" => "/routes/"
], function () {
    
    Route::get('new', [
        "as" => "routes.new",
        "uses" => "RoutesController@newRoute"
    ]);
    Route::get('newdetails/{p_routeTrace}', [
        "as" => "routes.newdetails",
        "uses" => "RoutesController@newDetails"
    ]);
    Route::post('save/add', [
        "as" => "routes.save.add",
        "uses" => "RoutesController@saveAddRoute"
    ]);
    Route::post('save/edit', [
        "as" => "routes.save.edit",
        "uses" => "RoutesController@saveUpdateRoute"
    ]);
    Route::get("trace/edit/{p_route}", [
        "as" => "routes.trace.edit",
        "uses" => "RoutesController@traceEdit"
    ]);
    Route::get("trace/update/{p_route}/{p_routeTrace}", [
        "as" => "routes.trace.update",
        "uses" => "RoutesController@traceUpdate"
    ]);
    Route::get('edit/{p_route}', [
        "as" => "routes.edit",
        "uses" => "RoutesController@editRoute"
    ]);
    Route::get("del/{p_route}", [
        "as" => "routes.del",
        "uses" => "RoutesController@delRoute"
    ]);
    Route::get('/', [
        "as" => "routes",
        "uses" => "RoutesController@listRoutes"
    ]);
});