<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ContactController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/not-found', function () {
    return view('not-found');
})->name('not-found');

Route::get('/group', [GroupController::class, 'index'])->name('groups.index');
Route::post('/group', [GroupController::class, 'store'])->name('groups.store');
Route::put('/group/{id}', [GroupController::class, 'update'])->name('groups.update');
Route::delete('/group/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');

Route::get('/contact', [ContactController::class, 'index'])->name('contacts.index');
Route::get('/contact/form', [ContactController::class, 'show'])->name('contacts.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contacts.store');
Route::put('/contact/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
