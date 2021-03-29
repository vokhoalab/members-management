<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::group(['middleware' => ['auth:sanctum','auth']], function () {
    // Route::middleware('permission:manage_users')->group(function () {
        Route::resource('users', 'UserController');
    // });
    // Route::group(['middleware' => ['role:director']], function () {
        // Roles
        Route::resource('roles', 'RoleController');
        Route::post('roles/{role}', 'RoleController@update');
    
        // Permissions
        Route::resource('permissions', 'PermissionController');

        Route::resource('departments', 'DepartmentController');

        Route::resource('teams', 'TeamController');

        Route::resource('members', 'MemberController');
    // });


});
