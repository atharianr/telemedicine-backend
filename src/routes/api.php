<?php

use App\Http\Controllers\API\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DoctorController;
use App\Http\Controllers\API\EmailVerificationController;
use App\Http\Controllers\API\UserController;

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
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::put('/user/edit', [UserController::class, 'editUser']);
    Route::get('/user/post_image', [UserController::class, 'postUserPhoto']);
    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    
    Route::get('/doctor', [DoctorController::class, 'getAllDoctors']);
    Route::get('/doctor/search', [DoctorController::class, 'searchFilterDoctor']);
    Route::get('/doctor/{id}', [DoctorController::class, 'getDoctorDetail']);

    Route::get('/article', [ArticleController::class, 'getAllArticles']);
    Route::get('/article/search', [ArticleController::class, 'searchArticle']);
    Route::get('/article/{id}', [ArticleController::class, 'getArticleDetail']);
});

