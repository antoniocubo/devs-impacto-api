<?php


use App\Http\Actions\Articles\AllArticlesGetAction;
use App\Http\Actions\Chat\CreateChatPostAction;
use App\Http\Actions\Category\CreateCategoryPostAction;
use App\Http\Actions\Category\ListCategoriesGetAction;
use App\Http\Actions\Poll\CreatePollPostAction;
use App\Http\Actions\Poll\ListPollsGetAction;
use App\Http\Actions\Poll\VotePollPostAction;
use App\Http\Actions\Post\CreatePostPostAction;
use App\Http\Actions\Post\ListPostsByCategoryGetAction;
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

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('chat')->group(function () {
            Route::post('/create', [CreateChatPostAction::class, '__invoke'])
                ->middleware('auth:sanctum');
            Route::post('send-message', [\App\Http\Actions\Chat\SendMessagePostAction::class, '__invoke'])
                ->middleware('auth:sanctum');
        });

        Route::prefix('articles')->group(function () {
            Route::get('/all', [AllArticlesGetAction::class, '__invoke']);
        });
    });

    Route::prefix('posts')->group(function () {
        Route::post('/', [CreatePostPostAction::class, '__invoke']);
        Route::get('category/{categoryId}', [ListPostsByCategoryGetAction::class, '__invoke']);
    });

    Route::prefix('categories')->group(function () {
        Route::post('/', [CreateCategoryPostAction::class, '__invoke']);
        Route::get('/', [ListCategoriesGetAction::class, '__invoke']);
    });

    Route::prefix('polls')->group(function () {
        Route::get('/', [ListPollsGetAction::class, '__invoke']);
        Route::post('/', [CreatePollPostAction::class, '__invoke'])
            ->middleware('auth:sanctum');
        Route::post('{pollId}/vote', [VotePollPostAction::class, '__invoke'])
            ->middleware('auth:sanctum');
    });
});
