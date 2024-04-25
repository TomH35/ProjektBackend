<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test-post', [TestController::class, 'testPost']);
Route::post('/stageCreate', [AdminController::class, 'createStage']);
Route::get('/GetData', [AdminController::class, 'GetData']);
Route::delete('/DeleteStage/{id}', [AdminController::class, 'deleteStage']);
Route::post('/editStage/{id}', [AdminController::class, 'editStage']);



