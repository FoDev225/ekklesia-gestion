<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\ActivityProgram;
use App\Models\TeamActivityDocument;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamActivityDocumentController extends Controller
{
    public function store(Request $request, Team $team, ActivityProgram $activityProgram)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,jpeg,png|max:10240',
            'presence_list_file_path' => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,jpeg,png|max:10240',
            'uploaded_by' => 'required|integer|exists:users,id',
        ]);

        $file = $request->file('file_path');
        $path = $file->store('team-activity-documents', 'public');

        $presenceListFile = $request->file('presence_list_file_path');
        $presenceListPath = $presenceListFile->store('team-activity-presence-lists', 'public');

        TeamActivityDocument::create([
            'team_id' => $team->id,
            'activity_program_id' => $activityProgram->id,
            'title' => $data['title'],
            'file_path' => $path,
            'presence_list_file_path' => $presenceListPath,
            'uploaded_by' => $data['uploaded_by'],
        ]);

        // AUTO : activité terminée
        $activityProgram->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Document ajouté et activité marquée comme terminée.');
    }

    public function destroy(Team $team, ActivityProgram $activityProgram, TeamActivityDocument $document)
    {
        abort_if($document->activity_program_id !== $activity->id, 404);

        Storage::disk('public')->delete($document->file_path);
        Storage::disk('public')->delete($document->presence_list_file_path);
        
        $document->delete();

        return back()->with('success', 'Document supprimé avec succès.');
    }
}
