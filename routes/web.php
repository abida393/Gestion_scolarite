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

Route::get('/welcome', [Controller::class, 'index'])->name('home.welcome');
Route::get('/mdpwrong', [Controller::class, 'mdpwrong'])->name('mdpwrong');
Route::get('/newmdp', [Controller::class, 'newmdp'])->name('newmdp');
Route::get('/calendar', [Controller::class, 'calendar'])->name('calendar');
Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome'])->name('home.welcome');

use App\Http\Controllers\EvenementController;

Route::get('/events', [EvenementController::class, 'index']);
Route::post('/events', [EvenementController::class, 'store']);
Route::put('/events/update/{id}', [EvenementController::class, 'update']);
Route::delete('/events/{id}', [EvenementController::class, 'destroy']);





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
Route::get('/home',[Controller::class,'home'])->name('home');
Route::get('/calendrier',[Controller::class, 'calendrier'])->name('calendrier');
Route::get('/notes',[Controller::class, 'notes'])->name('notes');
Route::get('/demande_documents',[Controller::class, 'demande_documents'])->name('demande_documents');
Route::get('/absence_justif',[Controller::class, 'absence_justif'])->name('absence_justif');
//Route::get('/stages',[Controller::class, 'stages'])->name('stages');
Route::get('/aide',[Controller::class, 'aide'])->name('aide');



use App\Http\Controllers\StageController;
Route::get('/stages', [StageController::class, 'index'])->name('stages.index');