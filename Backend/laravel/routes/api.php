<?php

use App\Http\Controllers\SponsorController;
use App\Http\Controllers\StageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TestMailController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/StageCreate', [StageController::class, 'createStage']);
Route::get('/StageRead', [StageController::class, 'readStage']);
Route::post('/StageUpdate/{id}', [StageController::class, 'updateStage']);
Route::delete('/StageDelete/{id}', [StageController::class, 'deleteStage']);
Route::post('/SponsorCreate', [SponsorController::class, 'createSponsor']);
Route::get('/SponsorRead', [SponsorController::class, 'readSponsor']);
Route::post('/SponsorUpdate/{id}', [SponsorController::class, 'updateSponsor']);
Route::delete('/SponsorDelete/{id}', [SponsorController::class, 'deleteSponsor']);
Route::post('/editorPost', [EditorController::class, 'store']);
Route::get('/editorPost/{id?}', [EditorController::class, 'show']);
Route::delete('editorDelete/{id}', [EditorController::class, 'editorDelete']);

Route::post('/test-post', [TestController::class, 'testPost']);
Route::post('/AdminRegistration', [AuthController::class, 'AdminRegistration']);
Route::post('/galleriesCreate', [GalleryController::class, 'createGallery']);
Route::get('/galleriesRead', [GalleryController::class, 'readGalleries']);
Route::get('/galleriesShow/{id}', [GalleryController::class, 'show']);
Route::post('/galleriesUpdate/{id}', [GalleryController::class, 'update']);
Route::delete('/galleriesDestroy/{id}', [GalleryController::class, 'destroy']);
Route::get('/about_us', [AboutUsController::class, 'index']);
Route::get('/about_us/{id}', [AboutUsController::class, 'show']);
Route::post('/about_us', [AboutUsController::class, 'store']);
Route::post('/about_us/{id}', [AboutUsController::class, 'update']);
Route::delete('/about_us/{id}', [AboutUsController::class, 'destroy']);
Route::get('/Speakers', [StageController::class, 'getSpeakers']);
Route::post('/register', [RegistrationController::class, 'store']);
Route::get('/events', [StageController::class, 'getEvents']);
Route::get('/EventsGroupedByTime', [StageController::class, 'getEventsGroupedByTime']);
Route::get('/SpeakerMenu', [SpeakerController::class, 'getAllSpeakers']);

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('SpeakerCreate', [SpeakerController::class, 'createSpeaker']);
    Route::delete('SpeakerDelete/{id}', [SpeakerController::class, 'deleteSpeaker']);
    Route::post('SpeakerUpdate/{id}', [SpeakerController::class, 'updateSpeaker']);
});

Route::get('/send-test-email', [TestMailController::class, 'sendTestEmail']);





