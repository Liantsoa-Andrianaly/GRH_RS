<?php

namespace App\Http\Controllers;

use App\Models\TypePrelevement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TypePrelevementController extends Controller
{
    public function index()
    {
        $types = TypePrelevement::orderBy('nom-complet')->get();
        return view('types_prelevements.index', compact('types'));
    }

    public function create()
    {
        return view('types_prelevements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'abreviation' => 'required|string|max:20|unique:types_prelevements,abreviation',
            'type_valeur' => 'required|in:montant,pourcentage',
            'valeur' => 'required|numeric|min:0',
        ]);

        if ($request->type_valeur === 'pourcentage' && $request->valeur > 100) {
            return back()->withErrors([
                'valeur' => 'La valeur ne peut pas dépasser 100% pour un pourcentage.'
            ])->withInput();
        }

        TypePrelevement::create($request->all());

        return redirect()
            ->route('types_prelevements.index')

            ->with('success', 'Type de prélèvement ajouté avec succès.');
    }

    public function edit(TypePrelevement $types_prelevement)
    {
        return view('types_prelevements.edit', compact('types_prelevement'));
    }

    public function update(Request $request, TypePrelevement $types_prelevement)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'abreviation' => 'required|string|max:20|unique:types_prelevements,abreviation,' . $types_prelevement->id,
            'type_valeur' => 'required|in:montant,pourcentage',
            'valeur' => 'required|numeric|min:0',
        ]);

        if ($request->type_valeur === 'pourcentage' && $request->valeur > 100) {
            return back()->withErrors([
                'valeur' => 'La valeur ne peut pas dépasser 100% pour un pourcentage.'
            ])->withInput();
        }

        $types_prelevement->update($request->all());

        return redirect()
            ->route('types_prelevements.index')
            ->with('success', 'Type de prélèvement modifié.');
    }

    public function destroy(TypePrelevement $types_prelevement)
    {
        $types_prelevement->delete();

        return redirect()
            ->route('types_prelevements.index')
            ->with('success', 'Type de prélèvement supprimé.');
    }
}

