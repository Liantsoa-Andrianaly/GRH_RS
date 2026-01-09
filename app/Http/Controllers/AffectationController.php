<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Employee;
use App\Models\Poste;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffectationController extends Controller
{
    // Affichage de la liste des employés avec postes et agences
    public function index()
    {
        $employees = Employee::with(['poste', 'agence'])->get();
        $postes = Poste::all();
        $agences = Agence::all();

        return view('affectations.index', compact('employees', 'postes', 'agences'));
    }

    // Récupérer les informations d'un employé + sa dernière affectation
    public function show(Employee $employee)
    {
        $employee->load(['poste', 'agence']);

        $lastAffectation = Affectation::where('employee_id', $employee->id)
            ->latest()
            ->first();

        return response()->json([
            'employee' => $employee,
            'affectation' => $lastAffectation
        ]);
    }

    // Créer une nouvelle affectation (poste + agence)
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'poste_nouveau_id' => 'required|exists:postes,id',
            'agence_nouveau_id' => 'required|exists:agences,id',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        // Création de l'affectation
        $affectation = Affectation::create([
            'employee_id' => $employee->id,
            'poste_ancien_id' => $employee->poste_id,
            'poste_nouveau_id' => $request->poste_nouveau_id,
            'agence_ancien_id' => $employee->agence_id,
            'agence_nouveau_id' => $request->agence_nouveau_id,
            'user_id' => Auth::id(),
            'date_creation' => now(),
        ]);

        // Mise à jour de l'employé
        $employee->update([
            'poste_id' => $request->poste_nouveau_id,
            'agence_id' => $request->agence_nouveau_id,
        ]);

        $affectation->load('posteAncien', 'posteNouveau', 'agenceAncien', 'agenceNouveau', 'user');

        return response()->json([
            'success' => true,
            'employee' => $employee->load('poste', 'agence'),
            'affectation' => $affectation
        ]);
    }

    // Historique des affectations
    public function historique(Employee $employee)
    {
        $historiques = Affectation::with([
            'posteAncien', 'posteNouveau',
            'agenceAncien', 'agenceNouveau',
            'user'
        ])
            ->where('employee_id', $employee->id)
            ->orderBy('date_creation', 'desc')
            ->paginate(1); // vous pouvez changer le nombre par page

        return response()->json($historiques);
    }
}
