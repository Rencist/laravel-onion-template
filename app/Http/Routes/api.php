<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleHasPermissionController;
  
Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);

// Region
Route::get('/province', [RegionController::class, 'getProvince']);
Route::get('/city', [RegionController::class, 'getCity']);
Route::get('/subdistrict', [RegionController::class, 'getSubdistrict']);
Route::get('/village', [RegionController::class, 'getVillage']);

// Forgot Password
Route::group(['prefix' => '/forgot_password'], function () {
    Route::post('/request', [UserController::class, 'requestForgotPassword']);
    Route::post('/change', [UserController::class, 'changeForgotPassword']);
});

//Stream Image
Route::get('/stream_image', [ImageController::class, 'streamImage']);

Route::middleware(['iam'])->group(
    function () {
        Route::get('test', function () {
            return response()->json([
                "success" => true,
                "message" => "User Berhasil Mengakses Endpoint Ini"
            ]);
        })->middleware('permission:test.index');

        //User
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/change_password', [UserController::class, 'changePassword']);

        //User
        Route::get('/users', [UserController::class, 'getUserList'])->middleware('permission:users.index');
        Route::delete('/users', [UserController::class, 'deleteUser'])->middleware('permission:users.delete');

        //Role
        Route::get('/roles', [RoleController::class, 'getRoleList'])->middleware('permission:roles.index');
        Route::post('/roles', [RoleController::class, 'add'])->middleware('permission:roles.store');
        Route::delete('/roles', [RoleController::class, 'delete'])->middleware('permission:roles.delete');
        Route::put('/roles', [RoleController::class, 'update'])->middleware('permission:roles.update');
        Route::get('/roles/{id_role}', [RoleHasPermissionController::class, 'getRolePermission'])->middleware('permission:roles.detail');
        Route::post('/roles_assign', [RoleHasPermissionController::class, 'add'])->middleware('permission:roles_assign.store');
        Route::delete('/roles_unassign', [RoleHasPermissionController::class, 'delete'])->middleware('permission:roles_unassign.store');

        //Permission
        Route::get('/permissions', [PermissionController::class, 'getPermissionList'])->middleware('permission:permissions.index');
        Route::post('/permissions', [PermissionController::class, 'add'])->middleware('permission:permissions.store');
        Route::delete('/permissions', [PermissionController::class, 'delete'])->middleware('permission:permissions.delete');
        Route::put('/permissions', [PermissionController::class, 'update'])->middleware('permission:permissions.update');
    }
);
