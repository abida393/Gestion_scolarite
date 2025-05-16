<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EmploiTempsController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\MessageController;

//=============Ajouter par imad===============
use App\Http\Controllers\NewsController;
// ===========================================


//==================================testemploi=========================================
// use App\Http\Controllers\EmploiDuTempsController;
// use App\Http\Controllers\ClasseController;
// use App\Http\Controllers\FiliereController;
// use App\Http\Controllers\MatiereController;
// use App\Http\Controllers\EnseignantController;
// ==================== AUTHENTICATION ====================
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('home.welcome');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
    Route::get('/mdpwrong', [AuthController::class, 'mdpwrong'])->name('mdpwrong');
    Route::get('/newmdp', [AuthController::class, 'newmdp'])->name('newmdp');
});

Route::middleware('auth.multi:responsable')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== PASSWORD RESET ====================
Route::get('/change-password', [PasswordResetController::class, 'edit'])->name('password.edit');
Route::put('/update-password', [PasswordResetController::class, 'update'])->name('password.change');

Route::get('/password/forgot', [PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/forgot', [PasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');

// ==================== ETUDIANT PAGES ====================
Route::middleware('auth.multi:etudiant')->group(function () {
    Route::get('/home', [Controller::class, 'home'])->name('home');
    Route::get('/calendar', [Controller::class, 'calendar'])->name('calendar');
    Route::get('/emploi', [Controller::class, 'emploi'])->name('emploi');
    Route::get('/calendrier', [Controller::class, 'calendrier'])->name('calendrier');
    Route::get('/notes', [Controller::class, 'notes'])->name('notes');
    Route::get('/demande_documents', [Controller::class, 'demande_documents'])->name('demande_documents');
    Route::get('/absence_justif', [Controller::class, 'absence_justif'])->name('absence_justif');
    Route::get('/stages', [Controller::class, 'stages'])->name('stages');
    Route::get('/aide', [Controller::class, 'aide'])->name('aide');
    Route::get('/profile', [Controller::class, 'profile'])->name('profile');
    Route::get('/paiement', [Controller::class, 'paiement'])->name('paiement');
    // Route::get('/messagerie', [MessageController::class, 'index'])->name('messagerie');
    // Étudiant
Route::get('/etudiant/news', [Controller::class, 'news'])->name('news');

});
// ==================== messagrie ===========================
Route::middleware(['auth:etudiant'])->group(function () {
    Route::get('/messagerie-etudiant', [MessageController::class, 'index'])->name('messagerie-etudiant');
    Route::get('/messages/{responsable}', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);
});
Route::middleware('auth:responsable')->group(function () {
    Route::get('/messagerie', [MessageController::class, 'indexResponsable'])->name('messagerie');
    Route::get('/responsable/messages/{etudiant}', [MessageController::class, 'getEtudiantMessages']);
    Route::post('/responsable/messages', [MessageController::class, 'sendResponsableMessage']);
});

// ==================== EMPLOI DU TEMPS ====================
Route::middleware('auth.multi:etudiant')->prefix('emploi')->group(function () {
    Route::get('/etudiant', [EmploiTempsController::class, 'emploiEtudiant'])->name('emploi.etudiant');
    Route::get('/download', [EmploiTempsController::class, 'download'])->name('emploi.download');
    Route::get('/etudiant/download', [EmploiTempsController::class, 'downloadForEtudiant'])->name('emploi_etudiant.download');
    Route::get('/emploi', [EmploiTempsController::class, 'emploiEtudiant'])->name('etudiant.emploi');

});
// ==================== EMPLOI DU TEMPS RESPONSABLE ====================
// Route::middleware('auth:responsable')->group(function () {
//     Route::get('/responsable/create_emploi_complet', [EmploiTempsController::class, 'createComplet'])->name('responsable.create_emploi_complet');
//     Route::post('/responsable/create_emploi_complet/store', [EmploiTempsController::class, 'storeMultiple'])->name('responsable.storeMultiple'); 
//     Route::get('/responsable/{timetable}/edit', [EmploiTempsController::class, 'edit_emploi'])->name('responsable.edit');
//     Route::put('/responsable/{timetable}', [EmploiTempsController::class, 'update'])->name('responsable.update');
//     Route::delete('/responsable/{timetable}', [EmploiTempsController::class, 'destroy'])->name('responsable.destroy');
//     Route::get('/responsable/emploi', action: [EmploiTempsController::class, 'afficherEmploi'])->name('responsable.emploi');
//     Route::get('/classe-details/{id}', [EmploiTempsController::class, 'getClasseDetails'])->name('classe.details');
//     Route::get('/responsable/download', [EmploiTempsController::class, 'download'])->name('responsable.download');
//     Route::get('/responsable/create', [EmploiTempsController::class, 'create'])->name('responsable.create');
//     Route::post('/responsable/store', [EmploiTempsController::class, 'store'])->name('responsable.store');

// });
// ==================== EMPLOI DU TEMPS ETUDIANT ====================
// Route::middleware('auth.multi:etudiant')->group(function () {
//     Route::get('/filieres-par-formation/{formationId}', [EmploiTempsController::class, 'getFilieresByFormation']);
//     Route::get('/classes-par-filiere/{filiereId}', [EmploiTempsController::class, 'getClassesByFiliere']);
//     Route::get('/dashboard', [EmploiTempsController::class, 'dashboard'])->name('dashboard');
//         Route::get('/emploi', [EmploiTempsController::class, 'emploiEtudiant'])->name('emploi');

// });

// ==================== EVENEMENTS ====================
Route::middleware('auth.multi:etudiant')->prefix('events')->group(function () {
    Route::get('/', [EvenementController::class, 'index']);
    Route::post('/', [EvenementController::class, 'store']);
    Route::put('/update/{id}', [EvenementController::class, 'update']);
    Route::delete('/{id}', [EvenementController::class, 'destroy']);
    Route::get('/list', [EvenementController::class, 'afficherEvenements'])->name('events');
});
// ==================== EVENEMENTS RESPONSABLE ==================== (Imad)
Route::middleware('auth.multi:responsable')->prefix('responsable/evenements')->group(function () {
    Route::get('/', [EvenementController::class, 'afficherEvenementsResponsable'])->name('responsable.events');
    Route::post('/', [EvenementController::class, 'addEvent'])->name('responsable.events.store');
    Route::put('/update/{id}', [EvenementController::class, 'updateEvent'])->name('responsable.events.update');
    Route::delete('/{id}', [EvenementController::class, 'deleteEvent'])->name('responsable.events.destroy');
});



// ==================== STAGES ====================
Route::get('/stage', [StageController::class, 'index'])->name('stages.index');
Route::get('/stage', [StageController::class, 'index'])->name('stages.index')->middleware("auth.multi:etudiant");


// ==================== STAGES RESPONSABLE ==================== (Imad)
Route::middleware(['auth:responsable'])->group(function () {
    // Afficher la liste des stages et le formulaire d'ajout
    Route::get('/stages', [StageController::class, 'indexResponsable'])->name('stages-responsable');
 
    // Ajouter un stage (traité par POST)
    Route::post('/stages', [StageController::class, 'store'])->name('stages.store');
 
    // Afficher le formulaire de modification d'un stage
    Route::get('/stages/edit/{id}', [StageController::class, 'edit'])->name('stages.edit');
 
    // Mettre à jour un stage
    Route::put('/stages/{id}', [StageController::class, 'update'])->name('stages.update');
 
    // Supprimer un stage
    Route::delete('/stages/{id}', [StageController::class, 'destroy'])->name('stages.destroy');
});


// ==================== ABSENCES ====================
Route::middleware('auth.multi:etudiant')->group(function () {
    Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');
    Route::post('/absences/justify/{id}', [AbsenceController::class, 'justify'])->name('absences.justify');
    Route::post('/justifier-absence', [AbsenceController::class, 'justifier'])->name('justifier-absence');
});
// ========ABSENCES responsables (route de la page ajouter par imad)=======
Route::middleware('auth.multi:responsable')->group(function () {
   Route::get('/responsable/absences', [AbsenceController::class, 'index'])->name('responsable.absences.index');
});


// ==================== NOTES ====================
Route::get('/notes/{etudiantId}', [NoteController::class, 'afficherNotes'])->middleware("auth.multi:etudiant");

// ==================== DOCUMENTS ====================
Route::middleware('auth.multi:etudiant')->prefix('documents')->group(function () {
    Route::post('/', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/', [DocumentController::class, 'documents'])->name('documents.index');
    Route::get('/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/{filename}', function ($filename) {
        return Storage::disk('documents')->download($filename);
    })->name('documents.file');
    Route::get('/{filename}/download', [DocumentController::class, 'downloadFile']);
});

Route::get('/demandes/{id}/download', [DocumentController::class, 'download'])->name('demandes.download');
// ==================== DOCUMENTS - RESPONSABLE ==================== (Imad)
Route::middleware('auth.multi:responsable')->prefix('responsable/documents')->group(function () {
    // Afficher toutes les demandes (responsable)
    Route::get('/', [DocumentController::class, 'indexResponsable'])->name('responsable.documents.index');

    // Modifier une demande (par exemple, modifier l'état)
    Route::get('/modifier/{id}', [DocumentController::class, 'modifier'])->name('responsable.demande.modifier');

    // Supprimer une demande
    Route::delete('/delete/{id}', [DocumentController::class, 'destroy'])->name('responsable.demande.supprimer');

    // Autres routes pour télécharger, ajouter un fichier, etc.
    Route::put('/update-etat/{id}', [DocumentController::class, 'updateEtat'])->name('responsable.demande.updateEtat');
    Route::get('/download/{id}', [DocumentController::class, 'downloadFile'])->name('documents.download');
    Route::post('/upload/{id}', [DocumentController::class, 'uploadDocument'])->name('responsable.demande.upload');
    Route::get('/modifier/{id}', [DocumentController::class, 'modifier'])->name('responsable.demande.modifier');

});




// ==================== CALENDRIER ====================
Route::prefix('calendrier')->name('calendar.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('calendrier');
    Route::post('/event/store', [CalendarController::class, 'storeEvent'])->name('event.store');
    Route::post('/plan/store', [CalendarController::class, 'storePlan'])->name('plan.store');
    
});
Route::middleware('auth:responsable')->group(function () {
     Route::get('/calendrier', [CalendarController::class, 'index'])->name('responsable.calendrier');
    Route::post('/responsable/event/store', [CalendarController::class, 'storeEvent'])->name('responsable.calendar.event.store');
    Route::post('/responsable/plan/store', [CalendarController::class, 'storePlan'])->name('responsable.calendar.plan.store');
    Route::get('/responsable/calendar/events', [CalendarController::class, 'getEvents'])->name('responsable.calendar.events');
    Route::put('/responsable/event/update/{id}', [CalendarController::class, 'update'])->name('responsable.calendar.event.update');
Route::get('/responsable/calendar/{id}/json', [CalendarController::class, 'getEventJson']);Route::delete('/responsable/calendar/{id}', [CalendarController::class, 'delete'])->name('responsable.calendar.delete');
// Route::get('/responsable/calendar/{id}', [CalendarController::class, 'show'])->name('responsable.calendar.show');
//  Route::delete('/calendar/{id}', [CalendarController::class, 'delete'])->name('responsable.calendar.delete');
 Route::delete('/calendar/{id}', [CalendarController::class, 'delete']);
  });  
Route::middleware(['auth.multi:etudiant'])->group(function () {
    Route::get('/etudiant/calendrier', [CalendarController::class, 'studentView'])->name('etudiant.calendrier');
    Route::get('/etudiant/events', [CalendarController::class, 'studentEvents'])->name('etudiant.events');
});

// ==================== CHATBOT ====================
Route::post('/chatbot/repondre', [ChatbotController::class, 'repondre'])->name('chatbot.repondre');
Route::get('/api/chatbot/messages', [ChatbotController::class, 'messages']);
Route::get('/chatbot', fn() => view('chatbot'));


// ==================== NEWS ==================== (Imad)
Route::middleware(['auth:responsable'])->group(function () {
    // Route pour afficher toutes les news
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');

    // Route pour ajouter une news
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    // Route pour afficher le formulaire d'édition d'une news
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');

    // Route pour mettre à jour une news
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');

    // Route pour supprimer une news
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
});
// ==================== TEST EMPLOI ====================
Route::prefix('responsable')->middleware(['auth:responsable'])->group(function() {
    // Emplois du temps
    Route::get('/emplois', [EmploiTempsController::class, 'affich'])->name('responsable.emploi');
    Route::get('/emplois/create', [EmploiTempsController::class, 'create'])->name('responsable.create');
    Route::post('/emplois', [EmploiTempsController::class, 'store'])->name('responsable.store');
    Route::get('/emploi/{id}/edit', [EmploiTempsController::class, 'edit'])->name('responsable.edit');
Route::put('/responsable/emploi/{id}', [EmploiTempsController::class, 'update'])->name('responsable.update');
    Route::delete('/emplois/{timetable}', [EmploiTempsController::class, 'destroy'])->name('responsable.destroy');
    Route::get('/emplois/pdf/{classeId}', [EmploiTempsController::class, 'emploiPdf'])->name('responsable.emploi_pdf');
    Route::post('/emplois', [EmploiTempsController::class, 'store'])->name('responsable.emploi.store');
    Route::post('/check-conflits', [EmploiTempsController::class, 'checkConflits'])->name('responsable.checkConflits');
    // Emploi complet
    Route::get('/emplois/complet', [EmploiTempsController::class, 'createComplet'])->name('responsable.create_emploi_complet');
    Route::post('/emplois/complet', [EmploiTempsController::class, 'storeMultiple'])->name('responsable.storeMultiple');
    // API pour les dépendances
    Route::get('/api/filieres', function(Request $request) {
        return \App\Models\Filiere::where('formation_id', $request->formation_id)
            ->orderBy('nom_filiere')
            ->get();
           

    });
    Route::get('/api/classes', function(Request $request) {
        return \App\Models\Classe::where('filiere_id', $request->filiere_id)
            ->orderBy('nom_classe')
            ->get();
    });
});
