<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::pattern("id","[0-9]+");
Route::pattern("p_id","[0-9]+");
Auth::routes();

Route::get('/home', 'HomeController@index');

/**
 * Guest routes
 */
Route::get('/',["as"=>"start","uses"=>"GuestController@start"]);
Route::get('/location/{p_id1}/{p_id2?}/{p_id3?}/{p_id4?}',["as"=>"start.location","uses"=>"GuestController@location"]);
Route::get('/routes/display/{p_id}',["as"=>"routes.display","uses"=>"GuestController@displayRoute"]);
Route::get("/routes/download/{p_id}",["as"=>"routes.download","uses"=>"GuestController@downloadRoute"]);
Route::post("/routes/search/",["as"=>"routes.search","uses"=>"GuestController@search"]);
/**
 * User routes
 */
Route::group(["middleware"=>"auth","prefix"=>"user/profile"],function(){
	Route::get("/",["as"=>"user.profile","uses"=>"UserController@displayProfile"]);
	Route::get("edit",["as"=>"user.editprofile","uses"=>"UserController@editProfile"]);
	Route::post("save",["as"=>"user.saveprofile","uses"=>"UserController@saveProfile"]);
	Route::get("password/edit",["as"=>"user.editpassword","uses"=>"UserController@editPassword"]);
	Route::post("password/save",["as"=>"user.savepassword","uses"=>"UserController@savePassword"]);
});
/**
 * URL for user management
 * -List all users
 * -Edit new user
 * -Edit existing user
 * -Delete user
 * -Save user (after edit)
 */
Route::group(["middleware"=>"auth","prefix"=>"/admin/users"],function(){
	Route::get('/',["as"=>"admin.users","uses"=>"AdminController@listusers"]);
	Route::get('new',["as"=>"admin.users.new","uses"=>'AdminController@newuser']);
	Route::get('edit/{p_user}',["as"=>"admin.users.edit","uses"=>"AdminController@edituser"]);
	Route::get('delete/{p_user}',["as"=>"admin.users.delete","uses"=>"AdminController@deleteUser"]);
	Route::post('add',["as"=>"admin.users.save.add","uses"=>"AdminController@saveUserAdd"]);
	Route::post('edit',["as"=>"admin.users.save.edit","uses"=>"AdminController@saveUserEdit"]);
});


Route::group(["middleware"=>"auth","prefix"=>"/traces/"],function(){
	Route::get("list",["as"=>"traces.list","uses"=>"TracesController@list"]);
	Route::get("download/{p_id}",["as"=>"traces.download","uses"=>"TracesController@download"]);
	Route::get("show/{p_id}",["as"=>"traces.show","uses"=>"TracesController@show"]);
});

/**
 * URLs for posting and editing hiking routes 
 */
Route::group(["middleware"=>"auth","prefix"=>"/routes/"],function(){
		
	Route::get('new',["as"=>"routes.new","uses"=>"RoutesController@newRoute"]);
	Route::get('newdetails/{id}',["as"=>"routes.newdetails","uses"=>"RoutesController@newDetails"]);
	Route::post("save/newupload",["as"=>"routes.save.newupload","uses"=>"RoutesController@saveNewUpload"]);
	Route::post('save/add',["as"=>"routes.save.add","uses"=>"RoutesController@saveAddRoute"]);
	Route::post('save/edit',["as"=>"routes.save.edit","uses"=>"RoutesController@saveUpdateRoute"]);
	Route::post("save/updategpx",["as"=>"routes.save.uploadgpx","uses"=>"RoutesController@saveUploadGPX"]);
	Route::get('edit{id}',["as"=>"routes.edit","uses"=>"RoutesController@editRoute"]);
	Route::get("del/{id}",["as"=>"routes.del","uses"=>"RoutesController@delRoute"]);
	Route::get("updategpx/{id}",["as"=>"routes.updategpx","uses"=>"RoutesController@uploadGPX"]);
	Route::get('editfile/{id}',["as"=>"routes.editfile","uses"=>"RoutesController@editFile"]);
	Route::get('/',["as"=>"routes","uses"=>"RoutesController@listRoutes"]);

});