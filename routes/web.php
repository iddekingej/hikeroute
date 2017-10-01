<?php


Route::pattern("id", "[0-9]+");
Route::pattern("p_id", "[0-9]+");
Route::pattern("p_id_route","[0-9]+");
Route::pattern("p_id_user","[0-9]+");
Route::pattern("p_flag","[01]");
Route::pattern("p_route","[0-9]+");
Route::pattern("p_routeTrace","[0-9]+");

Auth::routes();

Route::get('/home', 'HomeController@index');

/**
 * Guest routes
 */
Route::get('/', [
    "as" => "start",
    "uses" => "GuestController@start"
]);
Route::get('/location/{p_id1}/{p_id2?}/{p_id3?}/{p_id4?}', [
    "as" => "start.location",
    "uses" => "GuestController@location"
]);

/**
 * Routes for displaying images
 */
Route::group([
    "prefix"=>"/images/display/"
],
    function(){
        Route::get("display/{p_id_route_image}",[
            "as"=>"images.display"
           ,"uses"=>"ImageController@displayImage"]);
        
        Route::get("thumbnail/{p_id_route_image}",[
            "as"=>"images.thumbnail",
            "uses"=>"ImageController@displaythumbnail"]);
            }
);

/**
 * Album/Image administration
 * (Add/edit/del)
 */

Route::group([
    "prefix"=>"/images/edit/"
,    "middleware" => "auth"
],
    function(){
        Route::get("display/{p_id_route_image}",[
                "as"=>"images.edit"
            ,   "uses"=>"ImageController@editAlbum"
            ]
        );
        
        Route::get("add/{p_id}",[
            "as"=>"images.add",
            "uses"=>"ImageController@addImage"
            ]
        );
        Route::post("save",[
            "as"=>"images.save",
            "uses"=>"ImageController@saveImage"
        ]);
        Route::get("del/{p_id_routeImage}",[
            "as"=>"images.del",
            "uses"=>"ImageController@delImage"
            ]
        );
        Route::get("onsummary/{p_id_routeImage}/{p_flag}",[
            "as"=>"images.onsummary"
        ,   "uses"=>"ImageController@onSummary"
        ]);
        
        Route::get("moveup/{p_id_routeImage}",
            ["as"=>"images.moveup"
            ,"uses"=>"ImageController@moveUp"]);
        
        Route::get("movedown/{p_id_routeImage}",
            ["as"=>"images.movedown"
                ,"uses"=>"ImageController@moveDown"]);
        Route::get("rotr/{p_id_routeImage}",
            ["as"=>"images.rotr"
                ,"uses"=>"ImageController@rotr"]
            );
        Route::get("rotl/{p_id_routeImage}",
            ["as"=>"images.rotl"
                ,"uses"=>"ImageController@rotl"]
            );
    }
) ;  
    

/**
 * Display routes
 */
Route::group([
    "prefix"=>"/display/"
],function(){
    Route::get("album/{p_id_route}",[
        "as"=>"display.album",
        "uses"=>"DisplayController@album"
    ]);

    Route::get("trace/{p_id_route}",[
        "as"=>"display.trace"
        ,"uses"=>"DisplayController@trace"
    ]);

    Route::get('overview/{p_id_route}', [
        "as" => "display.overview",
        "uses" => "DisplayController@summary"
    ]);
});

Route::get("/routes/download/{p_id}", [
    "as" => "routes.download",
    "uses" => "GuestController@downloadRoute"
]);
Route::post("/routes/search/", [
    "as" => "routes.search",
    "uses" => "GuestController@search"
]);
/**
 * User routes
 */
Route::group([
    "middleware" => "auth",
    "prefix" => "user/profile"
], function () {
    Route::get("/", [
        "as" => "user.profile",
        "uses" => "ProfileController@displayProfile"
    ]);
    Route::get("edit", [
        "as" => "user.editprofile",
        "uses" => "ProfileController@editProfile"
    ]);
    Route::post("save", [
        "as" => "user.saveprofile",
        "uses" => "ProfileController@saveProfile"
    ]);
    Route::get("password/edit", [
        "as" => "user.editpassword",
        "uses" => "ProfileController@editPassword"
    ]);
    Route::post("password/save", [
        "as" => "user.savepassword",
        "uses" => "ProfileController@savePassword"
    ]);
});

require("admin.php");
require("admin.php");
require("traces.php");
require("routes.php");

