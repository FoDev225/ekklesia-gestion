<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Believer;
use App\Models\Team;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeamBelieversExport;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::withCount('believers')
            ->latest()
            ->paginate(10);
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string',
            'objectif' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Team::create($request->only('name', 'description', 'objectif', 'is_active'));

        return redirect()->route('admin.teams.index')
            ->with('success', 'L\'équipe a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $user = auth()->user();

        // SUPER ADMIN
        if (!$user->hasAnyRole(['pasteur', 'secretariat'])) {

            // RESPONSABLE D'ÉQUIPE
            if ($user->team_id != $team->id) {
                abort(403, 'Accès refusé : Vous n\'êtes pas autorisé à accéder à cette équipe.');
            }
        }

        // CHARGEMENT RELATIONS
        $team->load(['believers.address']);

        // FIDÈLES DISPONIBLES
        $availableBelievers = Believer::whereDoesntHave('teams', function ($query) use ($team) {
            $query->where('teams.id', $team->id);
        })
        ->orderBy('lastname')
        ->get();

        // STATISTIQUES
        $activitiesStats = [
            'total' => $team->activityPrograms()->count(),
            'scheduled' => $team->activityPrograms()->where('status', 'scheduled')->count(),
            'canceled' => $team->activityPrograms()->where('status', 'canceled')->count(),
            'completed' => $team->activityPrograms()->where('status', 'completed')->count(),
        ];

        // ACTIVITÉS RÉCENTES
        $recentActivities = $team->activityPrograms()
            ->latest()
            ->take(5)
            ->get();

        $year = request('year', now()->year);

        return view('admin.teams.show', compact(
            'team',
            'availableBelievers',
            'activitiesStats',
            'recentActivities',
            'year'
        ));
    }

    /**
     * Attribuer un fidèle à l’équipe
     */
    public function assignBeliever(Request $request, Team $team)
    {
        $request->validate([
            'believer_id' => 'required|exists:believers,id',
            'role' => 'nullable|string|max:100',
            'joined_at' => 'nullable|date',
        ]);

        if (!$team->believers()->where('believer_id', $request->believer_id)->exists()) {
            $team->believers()->attach($request->believer_id, [
                'role' => $request->role,
                'joined_at' => $request->joined_at,
            ]);
        }

        return redirect()->route('admin.teams.show', $team->id)
            ->with('success', 'Le fidèle a été attribué à l\'équipe avec succès.');
    }

    /**
     * Retirer un fidèle d’une équipe
     */
    public function removeBeliever(Team $team, Believer $believer)
    {
        $team->believers()->detach($believer->id);

        return redirect()->route('admin.teams.show', $team->id)
            ->with('success', 'Le fidèle a été retiré de l\'équipe avec succès.');
    }

    /**
     * Excel fidèle de l'équipe en excel
     */
    public function exportExcel(Request $request, Team $team)
    {
        return Excel::download(
            new TeamBelieversExport($team, $request->search, $request->gender),
            'equipe_' . str_replace(' ', '_', strtolower($team->name)) . '.xlsx'
        );
    }

    /**
     * Excel fidèle de l'équipe en pdf
     */

    public function exportPdf(Request $request, Team $team)
    {
        $believers = $team->believers()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('firstname', 'like', '%' . $request->search . '%')
                      ->orWhere('lastname', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->gender, function ($query) use ($request) {
                $query->where('gender', $request->gender);
            })
            ->get();

        $pdf = Pdf::loadView('admin.teams.exportPdf', compact('team', 'believers'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('equipe_' . str_replace(' ', '_', strtolower($team->name)) . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'description' => 'nullable|string',
            'objectif' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $team->update($request->only('name', 'description', 'objectif', 'is_active'));

        return redirect()->route('admin.teams.index')
            ->with('success', 'L\'équipe a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'L\'équipe a été supprimée avec succès.');
    }

}
