<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\FichePaieController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PrimeController;
use App\Http\Controllers\TypePrelevementController;


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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [EmployeeController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirections
    Route::get('/employe', fn() => redirect()->route('employees.index'));
    Route::get('/ajouter', fn() => redirect()->route('employees.create'));

    // Gestion employés
    Route::resource('employees', EmployeeController::class);
    Route::get('/employees-backup', [EmployeeController::class, 'liste_backup'])->name('employees.backup');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit-salaire', [EmployeeController::class, 'editSalaire'])->name('employees.editSalaire');
    Route::post('/employees/{id}/update-salaire', [EmployeeController::class, 'updateSalaire'])->name('employees.updateSalaire');





Route::get('/pointages', [PointageController::class, 'index'])->name('pointages.index');
Route::post('/pointages', [PointageController::class, 'store'])->name('pointages.store');
Route::get('/pointages/{pointage}/edit', [PointageController::class, 'edit'])->name('pointages.edit');
Route::put('/pointages/{pointage}', [PointageController::class, 'update'])->name('pointages.update');
Route::delete('/pointages/{pointage}', [PointageController::class, 'destroy'])->name('pointages.destroy');
Route::post('/pointages/{pointage}/sortie', [PointageController::class, 'pointerSortie'])->name('pointages.pointerSortie');

Route::get('/pointages/suivi', [PointageController::class, 'suiviPresence'])->name('pointages.suivi');


        
    Route::resource('agences', AgenceController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('postes', PosteController::class);

    Route::get('/affectations', [AffectationController::class, 'index'])->name('affectations.index');
    Route::get('/affectations/{employee}', [AffectationController::class, 'show']);
    Route::get('/affectations/historique/{employee}', [AffectationController::class, 'historique']);
    Route::post('/affectations', [AffectationController::class, 'store'])->name('affectations.store');

    
    Route::get('/conges', [CongeController::class, 'index'])->name('conges.index');
    Route::get('/conges/create', [CongeController::class, 'create'])->name('conges.create');
    Route::post('/conges', [CongeController::class, 'store'])->name('conges.store');
    Route::post('/conges/{id}/valider', [CongeController::class, 'valider'])->name('conges.valider');
    Route::post('/conges/{id}/refuser', [CongeController::class, 'refuser'])->name('conges.refuser');
    Route::get('/solde-conges', [CongeController::class, 'soldeTous'])->name('conges.solde');
    Route::get('/conges/{id}/pdf', [CongeController::class, 'telechargerPDF'])->name('conges.pdf');
    Route::get('/mes-conges', [CongeController::class, 'mesConges'])->name('conges.mes_conges');
    Route::post('/conges/valider/{id}', [CongeController::class, 'valider'])->name('conges.valider');

Route::get('conges/{id}/pdf', [CongeController::class, 'telechargerPDF'])
    ->name('conges.pdf')
    ->middleware('auth');
    Route::get('/conges/vider', [CongeController::class, 'viderTousLesConges'])->name('conges.vider');


    


// Backups
Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
Route::get('/backups/download/{filename}', [BackupController::class, 'download'])->name('backups.download');
Route::get('/backups/create', [BackupController::class, 'create'])->name('backups.create');



Route::resource('types_prelevements', TypePrelevementController::class);

require __DIR__.'/auth.php';