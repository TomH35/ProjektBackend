<?php

use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StageController;
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


Route::post('/StageCreate', [StageController::class, 'createStage']);
Route::get('/StageRead', [StageController::class, 'readStage']);
Route::post('/StageUpdate/{id}', [StageController::class, 'updateStage']);
Route::delete('/StageDelete/{id}', [StageController::class, 'deleteStage']);

Route::post('/SponsorCreate', [SponsorController::class, 'createSponsor']);
Route::post('/SponsorRead', [SponsorController::class, 'readSponsor']);



