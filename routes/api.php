<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Posts\{PostsDestroyController, PostsIndexController, PostsShowController, PostsStoreController, PostsUpdateController};
use App\Http\Controllers\Api\Users\{UsersDestroyController, UsersIndexController, UsersShowController, UsersUpdateController,UsersStoreController,UsersLoginController};
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
Route::prefix('auth')->group(function () {
    Route::post('/send_email', [UsersLoginController::class, 'sendVerificationCode'])->name('send.email');
    Route::post('/verify_code', [UsersLoginController::class, 'verifyCode'])->name('verify.code');

    
});



Route::prefix('user')->group(function (){
    
    // Route::post('/user_signup', [UsersStoreController::class,'output'])->name('register.user');
    Route::post('/user_signup', [UsersStoreController::class,'test'])->name('register.user');
    // Route::post('/user_signup', UsersStoreController::class)->name('register.user');

});

Route::middleware(['auth:sanctum', 'cache.headers:public;max_age=60;etag'])->group(function () {
    Route::get('/user',UsersShowController::class)->name('user.show');
    Route::put('/edit_profile', UsersUpdateController::class)->name('profile.update');

});