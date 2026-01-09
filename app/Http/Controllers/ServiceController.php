<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /** Liste des services */
    public function index()
    {
        $services = Service::with('postes')->paginate(6);
        return view('services.index', compact('services'));
    }

    /** Formulaire création service */
    public function create()
    {
        $service = null; // Pour le formulaire create
        return view('services.form', compact('service'));
    }

    /** Enregistrer un nouveau service */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')
                         ->with('success', 'Service créé avec succès.');
    }

    /** Formulaire édition service */
    public function edit(Service $service)
    {
        return view('services.form', compact('service'));
    }

    /** Mettre à jour un service */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')
                         ->with('success', 'Service mis à jour avec succès.');
    }

    /** Supprimer un service */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
                         ->with('success', 'Service supprimé avec succès.');
    }

    /** Affichage détails service */
    public function show(Service $service)
    {
        $service->load('postes'); // Charger les postes liés
        return view('services.show', compact('service'));
    }
}
