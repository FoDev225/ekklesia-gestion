<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuneralRegister;
use App\Models\Believer;
use App\Http\Requests\FuneralRegisterFormRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class FuneralRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funerals = FuneralRegister::with('believer')->orderBy('funeral_date', 'desc')->paginate(10);
        
        return view('admin.funerals.index', compact('funerals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $funeral = new FuneralRegister();

        return view('admin.funerals.form', compact('funeral'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FuneralRegisterFormRequest $request)
    {
        $funeral = FuneralRegister::create($request->validated());

        return redirect()->route('admin.funerals.show', $funeral)->with('success', 'LA fiche a été ajouté au registre des funérailles avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuneralRegister $funeral)
    {
        return view('admin.funerals.show', compact('funeral'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuneralRegister $funeral)
    {
        return view('admin.funerals.form', compact('funeral'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FuneralRegisterFormRequest $request, FuneralRegister $funeral)
    {
        $funeral->update($request->validated());

        return redirect()->route('admin.funerals.show', $funeral)->with('success', 'La fiche a été mise à jour avec succès.');
    }

    public function generatePdf(FuneralRegister $funeral)
    {
        // Logic to generate and return PDF for the funeral record
        $pdf = PDF::loadView('admin.funerals.pdf', compact('funeral'))->setPaper('A4', 'portrait');

        $filename = 'Fiche_funeraire_' . $funeral->parent_lastname . '_' . $funeral->parent_firstname . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuneralRegister $funeral)
    {
        //
    }
}
