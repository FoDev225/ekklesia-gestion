<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodes = Periode::latest()->paginate(10);

        return view('admin.periodes.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.periodes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'general_theme' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        // Si on active une nouvelle période -> désactiver les autres
        if (!empty($data['is_active'])) {
            Periode::where('is_active', true)->update(['is_active' => false]);
        }

        $data['is_active'] = $data['is_active'] ?? false;

        Periode::create($data);

        return redirect()->route('admin.periodes.index')->with('success', 'Période créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Periode $periode)
    {
        $periode->load('services');

        return view('admin.periodes.show', compact('periode'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Periode $periode)
    {
        return view('admin.periodes.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Periode $periode)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'general_theme' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
            'is_archived' => 'nullable|boolean',
        ]);

        // Si on active une nouvelle période -> désactiver les autres
        if (!empty($data['is_active'])) {
            Periode::where('is_active', true)
                ->where(['id', '!=', $periode->id])
                ->update(['is_active' => false]);
        }

        $periode->update([
            'name' => $data['name'],
            'general_theme' => $data['general_theme'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'is_active' => $data['is_active'] ?? false,
            'is_archived' => $data['is_archived'] ?? false,
        ]);

        return redirect()->route('admin.periodes.index')->with('success', 'Période mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Periode $periode)
    {
        if ($periode->services()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette période car elle est associée à un culte.');
        }

        $periode->delete();

        return back()->with('success', 'Période supprimée avec succès.');
    }

    /** 
     * Activer une période
     */
    public function activate(Periode $periode) 
    {
        Periode::where('is_active', true)->update(['is_active' => false]);

        $periode->update([
            'is_active' => true,
            'is_archived' => false,
        ]);

        return back()->with('success', 'Période activée avec succès.');
    }
}
