<?php


use App\Http\Actions\User\LoginPostAction;
use App\Http\Actions\User\LogoutPostAction;
use App\Http\Actions\User\RegisterUserPostAction;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('register', [RegisterUserPostAction::class, '__invoke']);
        Route::post('login', [LoginPostAction::class, '__invoke']);
        Route::post('logout', [LogoutPostAction::class, '__invoke'])
            ->middleware('auth:sanctum');
    });

});
