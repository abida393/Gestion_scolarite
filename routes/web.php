<?php

use App\Http\Controllers\Controller;
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

Route::get('/home',[Controller::class,'home'])->name('home');
Route::get('/calendrier',[Controller::class, 'calendrier'])->name('calendrier');
Route::get('/notes',[Controller::class, 'notes'])->name('notes');
Route::get('/demande_documents',[Controller::class, 'demande_documents'])->name('demande_documents');
Route::get('/absence_justif',[Controller::class, 'absence_justif'])->name('absence_justif');
Route::get('/stages',[Controller::class, 'stages'])->name('stages');
Route::get('/aide',[Controller::class, 'aide'])->name('aide');

