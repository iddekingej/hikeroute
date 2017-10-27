<?php 
/**
 * Routes for managing route traces
 */
Route::group([
    "middleware" => "auth",
    "prefix" => "/traces/"
], function () {
    Route::get("list", [
        "as" => "traces.list",
        "uses" => "TracesController@list"
    ]);
    Route::get("download/{p_id}", [
        "as" => "traces.download",
        "uses" => "TracesController@download"
    ]);
    Route::get("show/{p_id}", [
        "as" => "traces.show",
        "uses" => "TracesController@show"
    ]);
    Route::get("del/{p_routeTrace}", [
        "as" => "traces.del",
        "uses" => "TracesController@del"
    ]);
    Route::get("upload", [
        "as" => "traces.upload",
        "uses" => "TracesController@upload"
    ]);
    Route::Post("save", [
        "as" => "traces.save",
        "uses" => "TracesController@save"
    ]);
});