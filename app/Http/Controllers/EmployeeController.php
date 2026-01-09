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
            'date_embauche'      => 'nullable|date',
            'photo'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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


    $totalSupprimes = EmployeBackup::count();

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
        $employees = Employee::with('poste.service', 'agence')
                             ->paginate(5)
                             ->withQueryString();

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

            $data = $request->except('photo');

            //  Matricule sécurisé
            $data['matricule'] = $this->generateMatricule();

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('photos', 'public');
            }

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

        $data = $request->except('photo');

        // 🔒 Interdire la modification du matricule
        unset($data['matricule']);

        if ($request->hasFile('photo')) {
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $employee->update($data);

        return redirect()->route('employees.index')
                        ->with('success', 'Employé mis à jour avec succès.');
    }


    /**
     * Supprimer un employé et sauvegarder dans backup
     */
    public function destroy(Employee $employee)
    {
        EmployeBackup::create($employee->toArray() + [
            'deleted_at' => now(), // date exacte de suppression UTC
        ]);

        $employee->delete(); 

        return redirect()->route('employees.index')
                         ->with('success', 'Employé supprimé et sauvegardé.');
    }

    /**
     * Liste des backups
     */
    public function liste_backup()
    {
        $backups = EmployeBackup::latest()->paginate(10);

        $backups->transform(function ($backup) {
        $backup->deleted_at_local = $backup->deleted_at
            ? Carbon::parse($backup->deleted_at)
                    ->timezone(config('app.timezone'))
                    ->format('d/m/Y')
            : 'Non défini';
        return $backup;
    });


        return view('employees.backup', compact('backups'));
    }

    
    public function show(Employee $employee)
    {
        $employee->load([
            'poste.service',
            'agence',
            'conges' => function ($query) {
                $query->where('statut', 'valide')
                      ->orderBy('date_debut', 'desc');
            }
        ]);

      
        $employee->solde_conge_restant = $employee->solde_conge;

        if ($employee->solde_conge_restant < 0) {
            $employee->solde_conge_restant = 0; 
        }


        return view('employees.show', compact('employee'));
    }

    

}
