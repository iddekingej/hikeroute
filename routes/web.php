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

Auth::routes();

Route::get('/home', 'HomeController@index');

/**
 * Guest routes
 */
Route::get('/',["as"=>"start","uses"=>"GuestController@start"]);
Route::get('/routes/display/{p_id}',["as"=>"routes.display","uses"=>"GuestController@displayRoute"]);
Route::get("/routes/download/{p_id}",["as"=>"routes.download","uses"=>"GuestController@downloadRoute"]);

/**
 * URL for user management
 * -List all users
 * -Edit new user
 * -Edit existing user
 * -Delete user
 * -Save user (after edit)
 */
Route::get('/admin/users/',["as"=>"admin.users","uses"=>"AdminController@listusers"]);
Route::get('/admin/users/new',["as"=>"admin.users.new","uses"=>'AdminController@newuser']);
Route::get('/admin/users/edit/{id}',["as"=>"admin.users.edit","uses"=>"AdminController@edituser"]);
Route::get('/admin/users/delete/{id}',["as"=>"admin.users.delete","uses"=>"AdminController@deleteUser"]);
Route::post('/admin/users/save',["as"=>"admin.users.save","uses"=>"AdminController@saveUser"]);
/**
 * URLs for posting and editing hiking routes 
 */
Route::get('/routes/new',["as"=>"routes.new","uses"=>"RoutesController@newRoute"]);
Route::post("/routes/save/newupload",["as"=>"routes.save.newupload","uses"=>"RoutesController@saveNewUpload"]);
Route::post('/routes/save/add',["as"=>"routes.save.add","uses"=>"RoutesController@saveAddRoute"]);
Route::post('/routes/save/edit',["as"=>"routes.save.edit","uses"=>"RoutesController@saveUpdateRoute"]);
Route::post("/routes/save/updategpx",["as"=>"routes.save.uploadgpx","uses"=>"RoutesController@saveUploadGPX"]);
Route::get('/routes/edit{id}',["as"=>"routes.edit","uses"=>"RoutesController@editRoute"]);
Route::get("/routes/del/{id}",["as"=>"routes.del","uses"=>"RoutesController@delRoute"]);
Route::get("/routes/updategpx/{id}",["as"=>"routes.updategpx","uses"=>"RoutesController@updateGPX"]);
Route::get('/routes/editfile/{id}',["as"=>"routes.editfile","uses"=>"RoutesController@editFile"]);
Route::get('/routes/',["as"=>"routes","uses"=>"RoutesController@listRoutes"]);
