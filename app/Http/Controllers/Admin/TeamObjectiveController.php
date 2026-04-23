<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\TeamObjective;

class TeamObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Team $team)
    {
        return view('admin.teams.objectives.create', compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Team $team)
    {
        $validated = $request->validate([
            'year' => 'required|digits:4',
            'main_goal' => 'required|string|max:255',
            'budget_forecast' => 'nullable|numeric|min:0',
            'kpis' => 'nullable|string',
            'target_activities' => 'nullable|integer|min:0',
        ]);

        $exists = $team->objectives()->where('year', $validated['year'])->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['year' => 'Un objectif existe déjà pour cette année.'])->withInput();
        }

        $team->objectives()->create($validated);

        return redirect()->route('admin.teams.show', $team)->with('success', 'Objectif annuel créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team, TeamObjective $objective)
    {
        return view('admin.teams.objectives.edit', compact('team', 'objective'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team, TeamObjective $objective)
    {
        $validated = $request->validate([
            'year' => 'required|digits:4',
            'main_goal' => 'required|string|max:255',
            'budget_forecast' => 'nullable|numeric|min:0',
            'kpis' => 'nullable|string',
            'target_activities' => 'nullable|integer|min:0',
        ]);

        $exists = $team->objectives()
            ->where('year', $validated['year'])
            ->where('id', '!=', $objective->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['year' => 'Un objectif existe déjà pour cette année.'])->withInput();
        }

        $objective->update($validated);

        return redirect()->route('admin.teams.show', $team)->with('success', 'Objectif annuel mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team, TeamObjective $objective)
    {
        $objective->delete();

        return redirect()->route('admin.teams.show', $team)->with('success', 'Objectif supprimé avec succès.');
    }
}
