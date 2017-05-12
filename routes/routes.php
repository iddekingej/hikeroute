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
    Route::get('newdetails/{id}', [
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
    Route::get("trace/edit/{p_id}", [
        "as" => "routes.trace.edit",
        "uses" => "RoutesController@traceEdit"
    ]);
    Route::get("trace/update/{p_id_route}/{p_id}", [
        "as" => "routes.trace.update",
        "uses" => "RoutesController@traceUpdate"
    ]);
    Route::get('edit/{id}', [
        "as" => "routes.edit",
        "uses" => "RoutesController@editRoute"
    ]);
    Route::get("del/{id}", [
        "as" => "routes.del",
        "uses" => "RoutesController@delRoute"
    ]);
    Route::get('/', [
        "as" => "routes",
        "uses" => "RoutesController@listRoutes"
    ]);
});