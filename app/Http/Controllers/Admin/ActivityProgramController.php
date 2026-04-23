<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\ActivityProgram;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ActivityProgramController extends Controller
{
    public function index(Team $team)
    {
        $activities = $team->activityPrograms()
            ->with('documents')
            ->latest()
            ->paginate(10);
        
        /*
        |--------------------------------------------------------------------------
        | KPI PROGRAMME ANNUEL
        |--------------------------------------------------------------------------
        */
        $targetActivities = $team->objectives()->sum('target_activities');

        $completedActivities = $team->activityPrograms()
            ->where('status', 'completed')
            ->count();

        $completionRate = $targetActivities > 0
            ? round(($completedActivities / $targetActivities) * 100, 1)
            : 0;

        $budgetForecast = $team->objectives()->sum('budget_forecast');

        $totalExpenses = \App\Models\TeamActivityExpense::whereIn(
            'activity_program_id',
            $team->activityPrograms()->pluck('id')
        )->sum('amount');

        $budgetConsumptionRate = $budgetForecast > 0
            ? round(($totalExpenses / $budgetForecast) * 100, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | KPI COMPLEMENTAIRES
        |--------------------------------------------------------------------------
        */
        $plannedActivities = $team->activityPrograms()
            ->where('status', 'scheduled')
            ->count();

        $cancelledActivities = $team->activityPrograms()
            ->where('status', 'canceled')
            ->count();

        return view('admin.activities.index', compact(
            'team', 
            'activities',
            'targetActivities',
            'completedActivities',
            'completionRate',
            'budgetForecast',
            'totalExpenses',
            'budgetConsumptionRate',
            'plannedActivities',
            'cancelledActivities'
        ));
    }

    public function create(Team $team)
    {
        return view('admin.activities.create', compact('team'));
    }

    public function store(Request $request, Team $team)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'nullable|string',
            'moderator' => 'nullable|string|max:255',
            'preacher' => 'nullable|string|max:255',
            'scheduled_date' => 'nullable|date|',
            'month' => 'nullable|string|max:20',
            'year' => 'nullable|digits:4',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,canceled',
        ]);

        $team->activityPrograms()->create($request->all());

        return redirect()
            ->route('admin.teams.activities.index', $team)
            ->with('success', 'Activité ajoutée avec succès.');
    }

    public function show(Team $team, ActivityProgram $activity)
    {
        $activity->load(['expenses', 'documents']);

        $totalExpenses = $activity->expenses->sum('amount');
        
        return view('admin.activities.show', compact('team', 'activity', 'totalExpenses'));
    }

    public function edit(Team $team, ActivityProgram $activity)
    {
        return view('admin.activities.edit', compact('team', 'activity'));
    }

    public function update(Request $request, Team $team, ActivityProgram $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'nullable|string',
            'moderator' => 'nullable|string|max:255',
            'preacher' => 'nullable|string|max:255',
            'scheduled_date' => 'nullable|date|',
            'month' => 'nullable|string|max:20',
            'year' => 'nullable|digits:4',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,canceled',
        ]);

        $activity->update($request->all());

        return redirect()
            ->route('admin.teams.activities.index', $team)
            ->with('success', 'Activité mise à jour avec succès.');
    }

    public function annualReport(Request $request, Team $team)
    {
        $start = $request->start_date 
            ? Carbon::parse($request->start_date) 
            : Carbon::now()->startOfYear();

        $end = $request->end_date 
            ? Carbon::parse($request->end_date) 
            : Carbon::now()->endOfYear();

        // Activités sur la période
        $activities = $team->activityPrograms()
            ->whereBetween('scheduled_date', [$start, $end])
            ->with(['expenses', 'documents'])
            ->get();
        
        // KPI
        $totalActivities = $activities->count();

        $completedActivities = $activities
            ->where('status', 'completed')
            ->count();

        $totalExpenses = $activities->sum(function ($activity) {
            return $activity->expenses->sum('amount');
        });

        $completionRate = $totalActivities > 0
            ? round(($completedActivities / $totalActivities) * 100, 1)
            : 0;

        $objective = $team->objectives()->latest()->first();

        $pdf = Pdf::loadView('admin.activities.report_pdf', [
            'team' => $team,
            'activities' => $activities,
            'start' => $start,
            'end' => $end,
            'totalActivities' => $totalActivities,
            'completedActivities' => $completedActivities,
            'completionRate' => $completionRate,
            'totalExpenses' => $totalExpenses,
            'objective' => $objective
        ]);

        return $pdf->download('rapport-annuel-' .$team->name. '.pdf');
    }

    public function destroy(Team $team, ActivityProgram $activity)
    {
        $activity->delete();

        return back()->with('success', 'Activité supprimée avec succès.');
    }
}