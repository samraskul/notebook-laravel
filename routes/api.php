<?php

use App\Models\Post;
use App\Models\User;
use App\Models\NavbarMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\NavbarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Resources\NavbarMenuResource;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\NavbarMenuController;

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
    return $request->user()->makeVisible([
        'email'
    ]);
});

Route::post('login', [ApiAuthController::class, 'login']);
Route::post('register', [ApiAuthController::class, 'register']);

Route::group(['middleware'=>['auth:api']], function(){//auth:api
    
    Route::get('check', [ApiAuthController::class, 'check']);
    Route::get('navbar-menus', [NavbarMenuController::class, 'index']);
    Route::post('navbar-menus', [NavbarMenuController::class, 'store']);
    Route::post('navbar-menus-edit/{id}', [NavbarMenuController::class, 'update']);
    Route::get('navbar-menus-delete/{id}', [NavbarMenuController::class, 'delete']);

    Route::get('posts/{id}', [PostController::class, 'show'] );
    Route::post('posts/{id}', [PostController::class, 'update']);

});