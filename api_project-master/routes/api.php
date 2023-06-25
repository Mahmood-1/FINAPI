<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\http\Controllers\MyUserController;
use App\http\Controllers\ActivityController;
use App\http\Controllers\PostController;
use App\http\Controllers\GymController;
use App\http\Controllers\FoodController;
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
		Route::get('get/{gender}', [PostController::class, 'get_by_gender']);
		Route::post('create', [PostController::class, 'store']);
		Route::post('update/{id}', [PostController::class, 'update']);
		Route::get('show/{id}', [PostController::class, 'show']);
		Route::get('delete/{id}', [PostController::class, 'destroy']);
	});

	Route::prefix('gym')->group( function () {
		Route::post('create', [GymController::class, 'store']);
		Route::post('update/{id}', [GymController::class, 'update']);
		Route::get('show/{id}', [GymController::class, 'show']);
		Route::get('delete/{id}', [GymController::class, 'destroy']);
		Route::post('price/{id}/create', [GymController::class, 'add_prices']);
	});

	Route::prefix('food')->group( function () {
		Route::post('create', [FoodController::class, 'store']);
		Route::post('update/{id}', [FoodController::class, 'update']);
		Route::get('show/{id}', [FoodController::class, 'show']);
		Route::get('delete/{id}', [FoodController::class, 'destroy']);
		Route::post('meal/{id}/create', [FoodController::class, 'add_meals']);
	});

	Route::post('activity/create', [ActivityController::class, 'store']);
});
