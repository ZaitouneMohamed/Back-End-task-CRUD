<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("task", TaskController::class);
Route::put("SwitchTask/{task}",[TaskController::class , 'SwitchStatus']);
Route::controller(AuthController::class)->group(function () {
    Route::middleware("guest")->group(function () {
        Route::post("register", "register");
        Route::post("login", "login");
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get("profile", "profile");
        Route::post("logout", "logout");
    });
});
