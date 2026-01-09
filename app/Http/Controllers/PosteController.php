<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Service;
use Illuminate\Http\Request;

class PosteController extends Controller
{
    /** Liste des postes */
    public function index()
    {
        $postes = Poste::with('service')->paginate(6);
        return view('postes.index', compact('postes'));
    }

    /** Formulaire création */
    public function create()
    {
        $services = Service::all();
        return view('postes.form', ['poste' => null, 'services' => $services]);
    }

    /** Enregistrer un poste */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);

        Poste::create($request->all());

        return redirect()->route('postes.index')
                         ->with('success', 'Poste créé avec succès.');
    }

    /** Formulaire édition */
    public function edit(Poste $poste)
    {
        $services = Service::all();
        return view('postes.form', compact('poste', 'services'));
    }

    /** Mettre à jour */
    public function update(Request $request, Poste $poste)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);

        $poste->update($request->all());

        return redirect()->route('postes.index')
                         ->with('success', 'Poste mis à jour avec succès.');
    }

    /** Supprimer */
    public function destroy(Poste $poste)
    {
        $poste->delete();

        return redirect()->route('postes.index')
                         ->with('success', 'Poste supprimé avec succès.');
    }
}
