<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MyUserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PostController;
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

Route::post('register', [MyUserController::class, 'store']);
Route::post('login', [MyUserController::class, 'login']);
Route::post('forgot', [MyUserController::class, 'forgot']);
Route::post('reset/{code}', [MyUserController::class, 'reset']);

Route::middleware(['auth:api'])->group(function () {


	Route::prefix('user')->group( function () {
		Route::post('update/{id}', [MyUserController::class, 'update']);
		Route::get('show/{id}', [MyUserController::class, 'show']);
		Route::post('activity/create', [MyUserController::class, 'start_activity']);
	});

	Route::prefix('post')->group( function () {
		Route::post('create', [PostController::class, 'store']);
		Route::post('update/{id}', [PostController::class, 'update']);
		Route::get('show/{id}', [PostController::class, 'show']);
		Route::get('delete/{id}', [PostController::class, 'destroy']);
	});

	Route::post('activity/create', [ActivityController::class, 'store']);
});