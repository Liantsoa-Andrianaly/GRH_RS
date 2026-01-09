<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agence;

class AgenceController extends Controller
{
        public function index(Request $request)
    {
        $query = Agence::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $agences = $query->paginate(6)->withQueryString();

        return view('agences.index', compact('agences'));
    }


    public function create()
    {
        return view('agences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:agences',
            'nom' => 'required',
            'abreviation' => 'required',
        ]);

        Agence::create($request->all());

        return redirect()->route('agences.index')
                         ->with('success', 'Agence créée avec succès.');
    }

    public function edit(Agence $agence)
    {
        return view('agences.edit', compact('agence'));
    }

    public function update(Request $request, Agence $agence)
    {
        $request->validate([
            'code' => "required|unique:agences,code,$agence->id",
            'nom' => 'required',
            'abreviation' => 'required',
        ]);

        $agence->update($request->all());

        return redirect()->route('agences.index')
                         ->with('success', 'Agence mise à jour avec succès.');
    }

    public function destroy(Agence $agence)
    {
        $agence->delete();
        return redirect()->route('agences.index')
                         ->with('success', 'Agence supprimée.');
    }
}
