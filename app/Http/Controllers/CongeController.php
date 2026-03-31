<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CongeController extends Controller
{
    /**
     * Liste de tous les congés
     */
    public function index()
    {
        $conges = Conge::with('employee')->orderBy('created_at', 'DESC')->paginate(10);

        return view('conges.index', compact('conges'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $employees = Employee::where('solde_conge', '>', 0)
            ->orderBy('nom')
            ->get();

        return view('conges.create', compact('employees'));
    }

    /**
     * Enregistrer une demande de congé (NE MODIFIE PAS LE SOLDE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
            'type'        => 'required|string',
            'motif'       => 'nullable|string',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        // Nombre de jours demandés
        $nombreJours = Carbon::parse($request->date_debut)
            ->diffInDays(Carbon::parse($request->date_fin)) + 1;

        if ($employee->solde_conge < $nombreJours) {
            return back()->with('error', 'Solde de congé insuffisant.');
        }

        Conge::create([
            'employee_id' => $employee->id,
            'date_debut'  => $request->date_debut,
            'date_fin'    => $request->date_fin,
            'type'        => $request->type,
            'motif'       => $request->motif,
            'statut'      => 'en_attente',
            'nombre'      => $nombreJours,
            'solde_restant' => $employee->solde_conge - $nombreJours,
        ]);

        return redirect()->route('conges.index')
            ->with('success', 'Demande de congé enregistrée.');
    }

    /**
     * Validation RH (SEUL ENDROIT OÙ LE SOLDE CHANGE)
     */
public function valider($id)
{
    $conge = Conge::with('employee')->findOrFail($id);

    // Vérifie que le congé est en attente
    if ($conge->statut !== 'en_attente') {
        return back()->with('error', 'Ce congé est déjà traité.');
    }

    DB::transaction(function () use ($conge) {

        $employee = $conge->employee;

        // Vérifie si l'employé a assez de solde
        if ($employee->solde_conge < $conge->nombre) {
            throw new \Exception('Solde insuffisant');
        }

        // 🔹 CALCUL DU NOUVEAU SOLDE
        $newSolde = $employee->solde_conge - $conge->nombre;

        // 🔹 MET À JOUR LE SOLDE DE L'EMPLOYÉ
        $employee->update(['solde_conge' => $newSolde]);

        // 🔹 MET À JOUR LE CONGÉ
        $conge->update([
            'statut' => 'valide',
            'commentaire_validation' => 'Validé par le service RH',
            'solde_restant' => $newSolde
        ]);
    });

    return back()->with('success', 'Congé validé avec succès.');
}

    /**
     * Refuser un congé
     */
    public function refuser(Request $request, $id)
    {
        $request->validate([
            'commentaire_validation' => 'required|string',
        ]);

        $conge = Conge::findOrFail($id);

        $conge->update([
            'statut' => 'refuse',
            'commentaire_validation' => $request->commentaire_validation,
        ]);

        return redirect()->back()->with('success', 'Congé refusé.');
    }


    /**
     * Mes congés
     */
    public function mesConges()
    {
        $employee = auth()->user()->employee;

        $conges = Conge::where('employee_id', $employee->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->paginate(10);
        return view('conges.mes_conges', compact('conges'));
    }

    /**
     * Télécharger PDF
     */
    public function telechargerPDF($id)
    {
        $conge = Conge::with('employee')->findOrFail($id);

        $pdf = PDF::loadView('conges.pdf', compact('conge'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('conge_' . $conge->id . '.pdf');
    }

    /**
     * Réinitialiser tout
     */
    public function viderTousLesConges()
    {
        DB::transaction(function () {
            Conge::truncate();
            Employee::query()->update(['solde_conge' => 0]);
        });

        return redirect()->route('conges.index')
            ->with('success', 'Congés et soldes réinitialisés.');
    }
}
