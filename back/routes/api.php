<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('articles')->group(function ($router) {
    $router->get('/', [BlogController::class, 'getArticles']);
    $router->get('{id}', [BlogController::class, 'getOneArticle']);

    $router->middleware('auth:user')->group(function ($router) {
        $router->post('/', [BlogController::class, 'createArticle']);
    });
});



Route::prefix('users')->group(function ($router) {
    $router->post('/', [BlogController::class, 'registerUser']);

    $router->middleware('auth:admin')->group(function ($router) {
        $router->get('/', [BlogController::class, 'getUsers']);
        $router->delete('{userId}', [BlogController::class, 'deleteUser']);
    });
});


Route::prefix('auth')->group(function ($router) {
    $router->get('check', [AuthController::class, 'checkAuthentication']);
    
    $router->prefix('user')->group(function ($router) {
        $router->post('login', [AuthController::class, 'userLogin']);
        $router->post('logout', [AuthController::class, 'userLogout']);
    });

    $router->prefix('admin')->group(function ($router) {
        $router->post('login', [AuthController::class, 'adminLogin']);
        $router->post('logout', [AuthController::class, 'adminLogout']);
    });
});


Route::get('blog/{username}', [BlogController::class, 'showUserBlog']);

Route::fallback(function () {
    return response()->json(['message' => '404 Not Found'], 404);
});
