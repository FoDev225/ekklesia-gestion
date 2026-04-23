<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TeamActivityExpense;
use App\Models\ActivityProgram;
use App\Models\Team;

class TeamActivityExpenseController extends Controller
{
    public function store(Request $request, Team $team, ActivityProgram $activity)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $data['team_id'] = $team->id;
        $data['activity_program_id'] = $activity->id;
        $activity->expenses()->create($data);

        return back()->with('success', 'Dépense ajoutée avec succès.');
    }

    public function update(Request $request, Team $team, ActivityProgram $activity, TeamActivityExpense $expense)
    {
        abort_if($expense->activity_program_id !== $activity->id, 404);
        abort_if($expense->team_id !== $team->id, 404);
        
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $expense->update($data);

        return back()->with('success', 'Dépense mise à jour avec succès.');
    }

    public function destroy(Team $team, ActivityProgram $activity, TeamActivityExpense $expense)
    {
        abort_if($expense->activity_program_id !== $activity->id, 404);
        abort_if($expense->team_id !== $team->id, 404);

        $expense->delete();

        return back()->with('success', 'Dépense supprimée avec succès.');
    }
}
