<?php 
/**
 * URL for user management
 * -List all users
 * -Edit new user
 * -Edit existing user
 * -Delete user
 * -Save user (after edit)
 */

Route::group([
    "middleware" => "auth",
    "prefix" => "/admin/users"
], function () {
    Route::get('/', [
        "as" => "admin.users",
        "uses" => "AdminController@listusers"
    ]);
    Route::get('new', [
        "as" => "admin.users.new",
        "uses" => 'AdminController@newuser'
    ]);
    Route::get('edit/{p_user}', [
        "as" => "admin.users.edit",
        "uses" => "AdminController@edituser"
    ]);
    Route::get('delete/{p_user}', [
        "as" => "admin.users.delete",
        "uses" => "AdminController@deleteUser"
    ]);
    Route::post('add', [
        "as" => "admin.users.save.add",
        "uses" => "AdminController@saveUserAdd"
    ]);
    Route::post('edit/{p_user}', [
        "as" => "admin.users.save.edit",
        "uses" => "AdminController@saveUserEdit"
    ]);
});
