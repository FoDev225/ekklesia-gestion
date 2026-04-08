<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgrammeRequest;
use App\Models\Program;
use App\Models\ThemePrincipal;
use App\Models\SousTheme;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.gestion_cultes.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $program = new Program();

        return view('admin.gestion_cultes.programs.form', compact('program'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreProgrammeRequest $request)
    {
        DB::transaction(function () use ($request, &$programme) {

            // Désactiver les autres programmes
            if ($request->validated()['programme']['is_active']) {
                Programme::where('is_active', true)->update(['is_active' => false]);
            }

            /* ===================== PROGRAMME ===================== */
            $programme = Programme::create(
                $request->validated()['programme']
            );

            /* ===================== THEME PRINCIPAL ===================== */
            $themePrincipal = ThemePrincipal::create(
                array_merge(
                    ['program_id' => $programme->id],
                    $request->validated()['theme_principal']
                )
            );

            /* ===================== SOUS THEME ===================== */
            foreach ($request->validated()['sous_themes'] as $sousTheme) {
                SousTheme::create(
                    array_merge(
                        ['theme_principal_id' => $themePrincipal->id],
                        $sousTheme
                    )
                );
            }
        });

        return redirect()
            ->route('admin.programs.show', $programme->id)
            ->with('success', 'Programme créé avec succès.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        return view('admin.gestion_cultes.programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
