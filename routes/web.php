<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\WebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

Route::middleware(['auth'])->group(function () {
    // Aquí van las rutas de la aplicación

    //CATEGORIA
    Route::view('create-category', 'category/create-category')->name('create-category');
    Route::post('process-category-creation', [WebController::class, 'createCategory']); 

    Route::get('get-categories', [WebController::class, 'showCategories'])->name('get-categories');

    Route::get('edit-category/{id}', [WebController::class, 'updateCategoryView'])->where('id', '[0-9]+');
    Route::post('process-category-update', [WebController::class, 'processUpdateCategory']);

    Route::get('delete-category/{id}', [WebController::class, 'deleteCategory'])->where('id', '[0-9]+');

    //LIBROS
    Route::view('create-author', 'author/create-author')->name('create-author');
    Route::post('process-author-creation', [WebController::class, 'createAuthor']); 
});