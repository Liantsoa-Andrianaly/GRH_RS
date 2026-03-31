<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeBackup;
use App\Models\Service;
use App\Models\Poste;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Règles de validation pour création / mise à jour
     */
    private function validationRules()
    {
        return [
            'nom'                => 'required|string|max:255',
            'prenom'             => 'required|string|max:255',
            'sexe'               => 'required|in:Homme,Femme',
            'statut_matrimonial' => 'nullable|in:Célibataire,Marié(e),Divorcé(e),Veuf(ve)',
            'email'              => 'nullable|email|max:255',
            'adresse'            => 'required|string|max:255',
            'poste_id'           => 'required|exists:postes,id',
            'agence_id'          => 'required|exists:agences,id',
            'diplome'            => 'required|string|max:255',
            'cin'                => 'nullable|string|max:50',
            'permis_de_conduire' => 'nullable|string|max:50',
            'nationalite'        => 'nullable|string|max:100',
            'solde_conge'        => 'nullable|integer|min:0',
            'status'             => 'nullable|in:actif,demissionnaire,licencie,fin_cdd',
            'date_naissance'     => 'nullable|date',
            'date_embauche'      => 'nullable|date',
            'salaire_base'       => 'required|integer|min:0',

            
        ];
    }

    /**
     * Générer un matricule unique
     */
    /**
 * Génère un matricule unique et sûr (PostgreSQL friendly)
 */
   private function generateMatricule(): string
{
    $year = now()->format('Y');

    // Récupère le dernier numéro
    $lastNumber = DB::table('employees')
        ->where('matricule', 'like', "EMP-$year-%")
        ->orderBy('matricule', 'desc')
        ->value(DB::raw("CAST(SUBSTRING(matricule, 10) AS INTEGER)"));

    $nextNumber = ($lastNumber ?? 0) + 1;

    return "EMP-$year-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
}


public function dashboard()
{
    // Totaux simples
    $totalEmployees = Employee::count();
    $totalAgences = Agence::count();
    $totalServices = Service::count();
    $actifs = Employee::where('status', 'actif')->count();
    $inactifs = Employee::whereIn('status', ['demissionnaire','licencie','fin_cdd'])->count();


    // $totalSupprimes = EmployeBackup::count();
    $totalSupprimes = Employee::onlyTrashed()->count();

    // Répartition par service
    $employeesByService = Employee::with('poste.service')
        ->get()
        ->groupBy(fn($e) => $e->poste->service->nom ?? 'Sans service')
        ->map->count();

    // Répartition par agence
    $employeesByAgence = Employee::with('agence')
        ->get()
        ->groupBy(fn($e) => $e->agence->nom ?? 'Sans agence')
        ->map->count();

    return view('dashboard', [
        'totalEmployees' => $totalEmployees,
        'actifs' => $actifs,
        'inactifs' => $inactifs,
        'totalSupprimes' => $totalSupprimes, 
        'totalAgences' => $totalAgences,
        'totalServices' => $totalServices,
        'employeesByService' => $employeesByService,
        'employeesByAgence' => $employeesByAgence,
    ]);
}


    /**
     * Liste des employés avec pagination
     */
   public function index()
    {
        $employees = Employee::with(['poste.service', 'agence'])
            ->orderBy('nom', 'asc')
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        $agences = Agence::all();
        $services = Service::with('postes')->get();
        $employee = null;

        return view('employees.form', compact('agences', 'services', 'employee'));
    }

    /**
     * Formulaire édition
     */
    public function edit(Employee $employee)
    {
        $agences = Agence::all();
        $services = Service::with('postes')->get();

        return view('employees.form', compact('employee', 'agences', 'services'));
    }

    /**
     * Ajouter un employé
     */
public function store(Request $request)
{
    $request->validate($this->validationRules());

    return DB::transaction(function () use ($request) {

        $data = $request->only([
            'nom', 'prenom', 'sexe', 'statut_matrimonial',
            'email', 'telephone', 'adresse', 'diplome',
            'poste_id', 'agence_id', 'cin', 'permis_de_conduire',
            'nationalite', 'status', 'date_embauche',
            'date_naissance', 'lieu_naissance',
            'salaire_base', 'solde_conge',
        ]);

        $data['matricule'] = $this->generateMatricule();
        $data['solde_conge'] = $data['solde_conge'] ?? 0;

        Employee::create($data);

        return redirect()->route('employees.index')
            ->with('success', 'Employé ajouté avec succès.');
    });
}

    /**
     * Mettre à jour un employé
     */
public function update(Request $request, Employee $employee)
{
    $request->validate($this->validationRules());

    return DB::transaction(function () use ($request, $employee) {

        $data = $request->only([
            'nom', 'prenom', 'sexe', 'statut_matrimonial',
            'email', 'telephone', 'adresse', 'diplome',
            'poste_id', 'agence_id', 'cin', 'permis_de_conduire',
            'nationalite', 'status', 'date_embauche',
            'date_naissance', 'lieu_naissance',
            'salaire_base', 'solde_conge',
        ]);

        $data['solde_conge'] = $data['solde_conge'] ?? 0;

        $employee->update($data);

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Employé mis à jour avec succès.');
    });
}


    /**
     * Supprimer un employé et sauvegarder dans backup
     */


public function destroy(Employee $employee)
{
    $employee->delete(); // Soft delete → remplit deleted_at
    return redirect()->route('employees.index')
                     ->with('success', 'Employé supprimé avec succès.');
}
/**
 * Liste des backups
 */
public function liste_backup()
{
    $backups = Employee::onlyTrashed()->latest()->paginate(10);

    return view('employees.backup', compact('backups'));
}

    
    public function show(Employee $employee)
{
    $employee->load(['poste.service', 'agence', 'conges' => function ($query) {
        $query->where('statut', 'valide')->orderBy('date_debut', 'desc');
    }]);

    return view('employees.show', compact('employee'));
}

    

}