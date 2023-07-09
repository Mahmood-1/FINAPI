<?php


use App\Http\Controllers\dashboard\ActivityController;
use App\Http\Controllers\dashboard\food_MealsController;
use App\Http\Controllers\dashboard\FoodController;
use App\Http\Controllers\dashboard\GymController;
use App\Http\Controllers\dashboard\PostController;
use App\Http\Controllers\MyUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[FoodController::class,'index2'])->name('home');
Route::get('/login',[MyUserController::class,'login2'])->name('login');
Route::get('/home',[MyUserController::class,'ac_login'])->name('ac_login');

//Food
Route::group(['prefix' => 'Food', 'as' => 'food.'], function () {

    /* Name: Foods
     * Url: /Food/*
     * Route: food.*
     */
    Route::get('/', [FoodController::class, 'index'])->name('index');
    Route::get('create', [FoodController::class, 'create'])->name('create');
    Route::post('/', [FoodController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[FoodController::class,'edit']) ->name('edit');
    Route::put('/update/{id}',[FoodController::class,'update'])->name('update');
    Route::delete('/delete/{id}',[FoodController::class,'destroy']) ->name('delete');
});

//FoodM
Route::group(['prefix' => 'FoodM', 'as' => 'foodM.'], function () {

    /* Name: FoodM
     * Url: /FoodM/*
     * Route: foodM.*
     */
    Route::get('/', [food_MealsController::class, 'index'])->name('index');
    Route::get('create', [food_MealsController::class, 'create'])->name('create');
    Route::post('/', [food_MealsController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[food_MealsController::class,'edit']) ->name('edit');
    Route::put('/update/{id}',[food_MealsController::class,'update'])->name('update');
    Route::delete('/delete/{id}',[food_MealsController::class,'destroy']) ->name('delete');
});


//gym
Route::group(['prefix' => 'Gym', 'as' => 'gym.'], function () {

    /* Name: gym
     * Url: /Gym/*
     * Route: gym.*
     */
    Route::get('/', [GymController::class, 'index'])->name('index');
    Route::get('create', [GymController::class, 'create'])->name('create');
    Route::post('/', [GymController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[GymController::class,'edit']) ->name('edit');
    Route::put('/update/{id}',[GymController::class,'update'])->name('update');
    Route::delete('/delete/{id}',[GymController::class,'destroy']) ->name('delete');
});

//fitness
Route::group(['prefix' => 'Fitness', 'as' => 'fitness.'], function () {

    /* Name: Fitness
     * Url: /Fitness/*
     * Route: Fitness.*
     */
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('create', [PostController::class, 'create'])->name('create');
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[PostController::class,'edit']) ->name('edit');
    Route::put('/update/{id}',[PostController::class,'update'])->name('update');
    Route::delete('/delete/{id}',[PostController::class,'destroy']) ->name('delete');
});

//prices
Route::group(['prefix' => 'prices', 'as' => 'price.'], function () {

    /* Name: prices
     * Url: /prices/*
     * Route: prices.*
     */
    Route::get('/', [ActivityController::class, 'index'])->name('index');
    Route::get('create', [ActivityController::class, 'create'])->name('create');
    Route::post('/', [ActivityController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[ActivityController::class,'edit']) ->name('edit');
    Route::put('/update/{id}',[ActivityController::class,'update'])->name('update');
    Route::delete('/delete/{id}',[ActivityController::class,'destroy']) ->name('delete');
});
