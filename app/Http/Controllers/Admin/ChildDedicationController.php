<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChildDedication;
use App\Http\Requests\ChildDedicationFormRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class ChildDedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $child_dedications = ChildDedication::paginate(10);

        return view('admin.childdedications.index', compact('child_dedications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $child_dedication = new ChildDedication();

        return view('admin.childdedications.form', compact('child_dedication'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChildDedicationFormRequest $request)
    {
        $child_dedication = ChildDedication::create($request->validated());

        return redirect()->route('admin.child_dedications.show', $child_dedication)->with('success', 'La fiche de présentation de l\'enfant a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildDedication $child_dedication)
    {
        return view('admin.childdedications.show', compact('child_dedication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildDedication $child_dedication)
    {
        return view('admin.childdedications.form', compact('child_dedication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChildDedicationFormRequest $request, ChildDedication $child_dedication)
    {
        $child_dedication->update($request->validated());

        return redirect()->route('admin.child_dedications.show', $child_dedication)->with('success', 'La fiche de présentation de l\'enfant a été mise à jour avec succès.');
    }

    // Generate PDF for a child dedication
    public function generatePdf(ChildDedication $child_dedication)
    {
        $pdf = \PDF::loadView('admin.childdedications.fiche-pdf', compact('child_dedication'))->setPaper('A4', 'portrait');

        return $pdf->download("fiche_presentation_enfant_{$child_dedication->id}.pdf");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
