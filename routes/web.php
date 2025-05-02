<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EmploiTempsController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\AbsenceController;

// ==================== AUTHENTICATION ====================

Route::get('/', [AuthController::class, 'index'])->name('home.welcome')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login')->middleware('guest');
Route::get('/mdpwrong', [AuthController::class, 'mdpwrong'])->name('mdpwrong')->middleware('guest');
Route::get('/newmdp', [AuthController::class, 'newmdp'])->name('newmdp')->middleware('guest');
Route::get('/admin', [AuthController::class, 'admin'])->name('admin')->middleware('auth.multi:responsable');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/change-password', [PasswordResetController::class, 'edit'])->name('password.edit');
Route::put('/update-password', [PasswordResetController::class, 'update'])->name('password.update');

Route::get('/password/forgot', [PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/forgot', [PasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');

// ==================== GENERAL PAGES ====================

Route::get('/home', [Controller::class, 'home'])->name('home')->middleware("auth.multi:etudiant");
Route::get('/calendar', [Controller::class, 'calendar'])->name('calendar')->middleware("auth.multi:etudiant");
Route::get('/emploi', [Controller::class, 'emploi'])->name('emploi')->middleware("auth.multi:etudiant");
Route::get('/calendrier', [Controller::class, 'calendrier'])->name('calendrier')->middleware("auth.multi:etudiant");
Route::get('/notes', [Controller::class, 'notes'])->name('notes')->middleware("auth.multi:etudiant");
Route::get('/demande_documents', [Controller::class, 'demande_documents'])->name('demande_documents')->middleware("auth.multi:etudiant");
Route::get('/absence_justif', [Controller::class, 'absence_justif'])->name('absence_justif')->middleware("auth.multi:etudiant");
Route::get('/stages', [Controller::class, 'stages'])->name('stages')->middleware("auth.multi:etudiant");
Route::get('/aide', [Controller::class, 'aide'])->name('aide')->middleware("auth.multi:etudiant");
Route::get('/profile', [Controller::class, 'profile'])->name('profile')->middleware("auth.multi:etudiant");
Route::get('/paiement', [Controller::class, 'paiement'])->name('paiement')->middleware("auth.multi:etudiant");
Route::get('/messagerie', [Controller::class, 'messagerie'])->name('messagerie')->middleware("auth.multi:etudiant");
Route::get('/news', [Controller::class, 'news'])->name('news')->middleware("auth.multi:etudiant");

// ==================== EMPLOI DU TEMPS ====================

Route::get('/emploi/create', [EmploiTempsController::class, 'createComplet'])->name('emploi.create')->middleware("auth.multi:etudiant");
Route::get('/emploi/create-complet', [EmploiTempsController::class, 'createComplet'])->name('emploi.create_complet')->middleware("auth.multi:etudiant");
Route::post('/emploi', [EmploiTempsController::class, 'store'])->name('emploi.store')->middleware("auth.multi:etudiant");
Route::post('/emploi/store', [EmploiTempsController::class, 'store'])->name('emploi.store')->middleware("auth.multi:etudiant"); // could be removed if unnecessary duplicate
Route::post('/emploi/store-multiple', [EmploiTempsController::class, 'storeMultiple'])->name('emploi.storeMultiple')->middleware("auth.multi:etudiant");
Route::get('/emploi-etudiant', [EmploiTempsController::class, 'emploiEtudiant'])->name('emploi.etudiant')->middleware("auth.multi:etudiant");
Route::get('/emploi/{timetable}/edit', [EmploiTempsController::class, 'edit_emploi'])->name('emploi.edit')->middleware("auth.multi:etudiant");
Route::put('/emploi/{timetable}', [EmploiTempsController::class, 'update'])->name('emploi.update')->middleware("auth.multi:etudiant");
Route::delete('/emploi/{timetable}', [EmploiTempsController::class, 'destroy'])->name('emploi.destroy')->middleware("auth.multi:etudiant");
Route::get('/filieres-par-formation/{formationId}', [EmploiTempsController::class, 'getFilieresByFormation'])->middleware("auth.multi:etudiant");
Route::get('/classes-par-filiere/{filiereId}', [EmploiTempsController::class, 'getClassesByFiliere'])->middleware("auth.multi:etudiant");
Route::get('/dashboard', [EmploiTempsController::class, 'dashboard'])->name('dashboard')->middleware("auth.multi:etudiant");
Route::get('/emploi', [EmploiTempsController::class, 'showEmplois'])->name('emploi')->middleware("auth.multi:etudiant");

// ==================== EVENTS ====================

Route::get('/events', [EvenementController::class, 'index'])->middleware("auth.multi:etudiant");
Route::post('/events', [EvenementController::class, 'store'])->middleware("auth.multi:etudiant");
Route::put('/events/update/{id}', [EvenementController::class, 'update'])->middleware("auth.multi:etudiant");
Route::delete('/events/{id}', [EvenementController::class, 'destroy'])->middleware("auth.multi:etudiant");
Route::get('/evenements', [EvenementController::class, 'afficherEvenements'])->name('events')->middleware("auth.multi:etudiant");

// ==================== STAGE ====================

Route::get('/stage', [StageController::class, 'index'])->name('stages.index')->middleware("auth.multi:etudiant");

// ==================== ABSENCES ====================

Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index')->middleware("auth.multi:etudiant");
Route::post('/absences/justify/{id}', [AbsenceController::class, 'justify'])->name('absences.justify')->middleware("auth.multi:etudiant");
Route::post('/justifier-absence', [AbsenceController::class, 'justifier'])->name('justifier-absence')->middleware("auth.multi:etudiant");

// ==================== NOTES ====================

Route::get('/notes/{etudiantId}', [NoteController::class, 'afficherNotes'])->middleware("auth.multi:etudiant");
