<?php

use App\Http\Controllers\API\MarkersController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'markers', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MarkersController::class, 'index']);
    Route::post('add', [MarkersController::class, 'add']);
    Route::get('edit/{id}', [MarkersController::class, 'edit']);
    Route::post('update/{id}', [MarkersController::class, 'update']);
    Route::delete('delete/{id}', [MarkersController::class, 'delete']);
});
