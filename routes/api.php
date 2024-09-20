<?php

use App\Http\Controllers\API\AppSettingsController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MeetingController;
use App\Http\Controllers\API\AIGeneratorController;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', function () {
    Auth::logout();
    return response()->json([
        "message" => "Logout successful"
    ]);
});

Route::post('password/reset/init', [AuthController::class, 'password_reset']); //->name('password.forgot');
// Route::get('password/update/{code}/{email}', PasswordResetLivewire::class)->name('password.reset.link');

Route::get('public/meetings', [MeetingController::class, 'publicMeeting']);
Route::post('meetings', [MeetingController::class, 'store']);
Route::get('meetings/join/{id}', [MeetingController::class, 'join']);

//
Route::get('app/settings', [AppSettingsController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::apiResource('meetings', MeetingController::class)->only('index', 'update', 'destroy');
    Route::put('profile/update', [AuthController::class, 'profileUpdate']);
    Route::delete('profile/delete', [AuthController::class, 'deleteProfile']);
});


//AI Routes
Route::group(['middleware' => ['aiAuthCheck']], function () {
    Route::post('ai/chat', [AIGeneratorController::class, 'chat']);
    Route::post('ai/image/generate', [AIGeneratorController::class, 'imageGenerate']);
});
