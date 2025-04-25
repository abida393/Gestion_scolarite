<?php

use App\Http\Controllers\Controller;
use App\Models\emplois_temps;
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

// use App\Http\Controllers\TimetableController;

Route::get('/welcome', [Controller::class, 'index'])->name('home');
Route::get('/mdpwrong', [Controller::class, 'mdpwrong'])->name('mdpwrong');
Route::get('/newmdp', [Controller::class, 'newmdp'])->name('newmdp');
Route::get('/calendar', [Controller::class, 'calendar'])->name('calendar');





use App\Http\Controllers\EmploiTempsController;
// use Illuminate\Support\Facades\Route;

Route::get('/emploi', [EmploiTempsController::class, 'emploi'])->name('emploi');
Route::get('/emploi/create', [EmploiTempsController::class, 'create'])->name('emploi.create');
Route::post('/emploi/store', [EmploiTempsController::class, 'store'])->name('emploi.store');
Route::get('/emploi/{timetable}/edit', [EmploiTempsController::class, 'edit'])->name('emploi.edit');
Route::put('/emploi/{timetable}', [EmploiTempsController::class, 'update'])->name('emploi.update');
Route::delete('/emploi/{timetable}', [EmploiTempsController::class, 'destroy'])->name('emploi.destroy');

// Removed invalid Route::resource() call
// Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
// Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
// Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
