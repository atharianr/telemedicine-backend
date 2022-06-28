<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmailVerificationController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class,'verify'])->name('verification.verify');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $response = [
            'message' => 'User fetched',
            'data' => $request->user()
        ];
        return $response;
    });
    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
});
