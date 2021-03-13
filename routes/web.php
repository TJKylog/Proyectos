<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/',[App\Http\Controllers\HomeController::class, 'root'])->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group( ['middleware' => ['web', 'auth']], function () {
    Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->middleware(['role:Student']);
    Route::get('/projects/new', [App\Http\Controllers\ProjectController::class, 'create'])->middleware(['role:Student']);
    Route::get('/subjects', [App\Http\Controllers\ProjectController::class, 'get_subjects']);
    Route::get('/technologies', [App\Http\Controllers\ProjectController::class, 'get_technologies']);
    Route::get('/skills', [App\Http\Controllers\ProjectController::class, 'get_skills']);
});
