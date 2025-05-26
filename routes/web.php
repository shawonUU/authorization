<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('pages.index');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', fn() => 'Welcome Admin');
});

Route::middleware(['permission:edit_post'])->group(function () {
    Route::get('/edit-post', fn() => 'You can edit post');
});

Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
