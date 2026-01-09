<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class PointageController extends Controller
{
    // Page principale des pointages
    public function index()
    {
        $employees = Employee::orderBy('nom')->get();

        $pointages = Pointage::with('employee')
            ->orderBy('entree', 'desc')
            ->paginate(8); 
        return view('pointages.index', compact('employees', 'pointages'));
    }


    // Enregistrer un pointage
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'entree' => 'required|date',
            'sortie' => 'nullable|date|after_or_equal:entree',
        ]);

        $entree = new Carbon($request->entree);
        $sortie = $request->sortie ? new Carbon($request->sortie) : null;

        $pointage = Pointage::create([
            'employee_id' => $request->employee_id,
            'entree' => $entree,
            'sortie' => $sortie,
        ]);

        $pointage->calculerMinutesTotal();
        $pointage->save();

        return redirect()->route('pointages.index')->with('success', 'Pointage enregistré.');
    }

    // Editer un pointage
    public function edit(Pointage $pointage)
    {
        $employees = Employee::orderBy('nom')->get();
        return view('pointages.edit', compact('pointage', 'employees'));
    }

    // Mettre à jour un pointage
    public function update(Request $request, Pointage $pointage)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'entree' => 'required|date',
            'sortie' => 'nullable|date|after_or_equal:entree',
        ]);

        $pointage->employee_id = $request->employee_id;
        $pointage->entree = new Carbon($request->entree);
        $pointage->sortie = $request->sortie ? new Carbon($request->sortie) : null;
        $pointage->calculerMinutesTotal();
        $pointage->save();

        return redirect()->route('pointages.index')->with('success', 'Pointage modifié.');
    }

    // Supprimer un pointage
    public function destroy(Pointage $pointage)
    {
        $pointage->delete();
        return redirect()->back()->with('success', 'Pointage supprimé.');
    }

    // Pointer la sortie d’un employé
    public function pointerSortie(Pointage $pointage)
    {
        if (!$pointage->sortie) {
            $pointage->sortie = Carbon::now();
            $pointage->calculerMinutesTotal();
            $pointage->save();

            return redirect()->route('pointages.index')->with('success', 'Sortie pointée avec succès.');
        }

        return redirect()->route('pointages.index')->with('error', 'La sortie a déjà été pointée.');
    }

   // Suivi des présences avec pagination
    public function suiviPresence(Request $request)
    {
        $employees = Employee::where('status', 'actif')->orderBy('nom')->get();

        // Filtrage par date si demandé
        $filterDate = $request->input('date');

        // Récupérer toutes les dates distinctes (avec pagination)
        $datesQuery = Pointage::selectRaw('DATE(entree) as date')->distinct()->orderBy('date', 'desc');

        if ($filterDate) {
            $datesQuery->whereDate('entree', $filterDate);
        }

        // Pagination manuelle
        $perPage = 2; // nombre de dates par page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $datesCollection = collect($datesQuery->pluck('date')); // transforme en collection
        $currentPageItems = $datesCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $dates = new LengthAwarePaginator(
            $currentPageItems,
            $datesCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Construire le tableau des présences
        $presences = [];
        foreach ($dates as $date) {
            $pointages = Pointage::whereDate('entree', $date)->pluck('employee_id')->toArray();
            foreach ($employees as $employee) {
                $presences[$date][$employee->id] = in_array($employee->id, $pointages);
            }
        }

        return view('pointages.suivi', compact('employees', 'dates', 'presences'));
    }

}