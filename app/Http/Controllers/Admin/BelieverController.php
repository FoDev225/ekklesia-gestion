<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Believer;
use App\Models\Language;
use App\Models\DisciplinarySituation;
use App\Models\BelieverDeparture;
use App\Models\Group;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\BelieverFormRequest;
use Illuminate\Support\Facades\DB;

use App\Services\BelieverService;
use App\Exports\BelieverImportTemplateExport;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

use App\Exports\BelieversExport;
use App\Imports\BelieverImport;

class BelieverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $believers = Believer::latest()->paginate(10);

        return view('admin.believers.index', compact('believers'));

        // $believers = Believer::when($request->search, fn ($q) =>
        // $q->search($request->search)
        // )
        // ->latest()
        // ->paginate(15)
        // ->withQueryString();
    }

    public function search(Request $request)
    {
        try {
            $search = $request->get('search');

            $believers = Believer::when($search, fn ($q) =>
                    $q->search($search)
                )
                ->latest()
                ->limit(20)
                ->get();

            return view('admin.believers.partials.table', compact('believers'))->render();

        } catch (\Throwable $e) {
            logger()->error($e);
            return response('Erreur serveur', 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages  = Language::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();
        $believer = new Believer();

        return view('admin.believers.form', compact('believer', 'languages', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BelieverFormRequest $request, BelieverService $service)
    {
        try {
            $believer = $service->create($request->validated());

            return redirect()
                ->route('admin.believers.show', $believer)
                ->with('success', 'Le fidèle a été créé avec succès.');

        } catch (\Throwable $e) {
            logger()->error($e);
            return back()->withInput()->withErrors('Une erreur est survenue lors de la création du fidèle.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Believer $believer)
    {
        return view('admin.believers.show', compact('believer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Believer $believer)
    {
        // $believer->load([
        //     'address',
        //     'churchInformation',
        //     'education',
        //     'profession',
        //     'responsibility',
        //     'languages',
        //     'groups',
        //     'departments',
        // ]);
        
        $languages = Language::orderBy('name')->get();
        $groups = Group::orderBy('name')->get();

        return view('admin.believers.form', compact('believer', 'languages', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BelieverFormRequest $request, Believer $believer, BelieverService $service)
    {
        try {
            $service->update($believer, $request->validated());

            return redirect()
                ->route('admin.believers.show', $believer)
                ->with('success', 'Le fidèle a été mis à jour avec succès.');

        } catch (\Throwable $e) {
            logger()->error($e);
            return back()->withInput()->withErrors('Une erreur est survenue lors de la mise à jour du fidèle.');
        }
    }

    // SET DISCIPLINARY STATUS
    public function applyDiscipline(Request $request, Believer $believer)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'observations' => 'nullable|string',
        ]);

        // DEACTIVATE ANY EXISTING ACTIVE DISCIPLINARY SITUATIONS
        $believer->disciplinarySituations()->where('status', 'active')->update(['status' => 'inactive']);

        // CREATE A NEW DISCIPLINARY SITUATION
        $believer->disciplinarySituations()->create([
            'reason' => $request->reason,
            'start_date' => now(),
            'observations' => $request->observations,
            'status' => 'active',
        ]);

        return redirect()->route('admin.believers.show', $believer)->with('success', 'Le fidèle a été mis sous discipline.');
    }

    // UNSET DISCIPLINARY STATUS
    public function liftDiscipline(Request $request, Believer $believer)
    {
        // FIND THE ACTIVE DISCIPLINARY SITUATION
        $disciplinarySituation = $believer->disciplinarySituations()->where('status', 'active')->first();

        if ($disciplinarySituation) {
            // SET THE STATUS TO INACTIVE
            $disciplinarySituation->update([
                'status' => 'inactive',
                'end_date' => now(),
            ]);
        }

        return redirect()->route('admin.believers.show', $believer)->with('success', 'La discipline du fidèle a été levée.');
    }

    // Génération de la fiche PDF du fidèle
    public function generatePdf(Believer $believer)
    {
        // Logique pour générer le PDF
        $pdf = Pdf::loadview('admin.believers.pdf', compact('believer'))->setPaper('A4', 'portrait');

        $filename = 'Fiche_fidele_' . $believer->lastname . '_' . $believer->firstname . '.pdf';

        return $pdf->download($filename);
    }

    // Export des fidèles en Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new BelieversExport(
                $request->baptized,
                $request->discipline,
                $request->category_id
            ),
            'liste_des_fideles.xlsx'
        );
    }

    public function downloadImportTemplate()
    {
        return Excel::download(
            new BelieverImportTemplateExport,
            'modele_import_fideles.xlsx'
        );
    }

    // Import des fidèles depuis un fichier Excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'import_mode' => 'required|in:ignore,update',
        ]);

        try {
            $import = new BelieverImport($request->import_mode);
            Excel::import($import, $request->file('file'));

            $message = "Import terminé avec succès. ";
            $message .= "{$import->successCount} fidèle(s) importé(s), ";
            $message .= "{$import->updatedCount} mis à jour, ";
            $message .= "{$import->ignoredCount} ignoré(s), ";
            $message .= "{$import->errorCount} erreur(s).";

            return redirect()->back()->with([
                'success' => $message,
                'import_errors' => $import->report,
            ]);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Erreur lors de l’import : ' . $e->getMessage());
        }
    }

    // AFFICHER TOUTES LES SANCTIONS DISCIPLINAIRES
    public function disciplinarySanction()
    {
        $sanctions = DisciplinarySituation::with('believer')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.believers.sanctions', compact('sanctions'));
    }

    // FIDELE QUI QUITTE LA COMMUNAUTE
    public function leave(Request $request, Believer $believer)
    {
        $request->validate([
            'type' => 'required|in:quit,deceased',
            'reason' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'departure_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $believer) {
            BelieverDeparture::create([
                'believer_id' => $believer->id,
                'type' => $request->type,
                'reason' => $request->reason,
                'comment' => $request->comment,
                'departure_date' => $request->departure_date,
            ]);

            $believer->update([
                'is_active' => false,
                'left_at' => $request->type === 'quit' ? $request->departure_date : null,
                'deceased_at' => $request->type === 'deceased' ? $request->departure_date : null,
            ]);
        });

        return redirect()->route('admin.believers.index')->with('success', 'Statut du fidèle mis à jour.');
    }

    // REINTEGRER UN FIDELE
    public function reintegrate(Believer $believer)
    {
        if (!$believer->canBeReintegrated()) {
            abort(403, 'Ce fidèle ne peut pas être réintégré.');
        }

        $believer->update([
            'is_active' => true,
            'left_at' => null,
        ]);

        return back()->with('success', 'Fidèle réintégré avec succès.');
    }

    // AFFICHER TOUS CEUX QUI ONT QUITTÉ LA COMMUNAUTÉ
    public function departures()
    {
        $departures = BelieverDeparture::with('believer')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.believers.departures', compact('departures'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
