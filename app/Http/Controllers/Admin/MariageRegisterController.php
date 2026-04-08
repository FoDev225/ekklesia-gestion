<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MariageRegister;
use App\Http\Requests\MariageRegisterFormRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class MariageRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mariages = MariageRegister::with('groom', 'bride')->orderBy('religious_marriage_date', 'desc')->paginate(10);

        return view('admin.mariages.index', compact('mariages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mariage = new MariageRegister();

        return view('admin.mariages.form', compact('mariage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MariageRegisterFormRequest $request)
    {
        $data = $request->validated();
        // Gestion de la photo
        if ($request->hasFile('groom_photo')) {
            $file = $request->file('groom_photo'); 
            $filename = time() . '.' . $file->extension();
            $path = $file->storeAs('mariages_photos', $filename, 'public');
            $data['groom_photo'] = $path;
        }

        if ($request->hasFile('bride_photo')) {
            $file = $request->file('bride_photo'); 
            $filename = time() . '.' . $file->extension();
            $path = $file->storeAs('mariages_photos', $filename, 'public');
            $data['bride_photo'] = $path;
        }

        $mariage = MariageRegister::create($data);

        return redirect()->route('admin.mariages.index')->with('success', 'La fiche a été ajoutée au registre avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MariageRegister $mariage)
    {
        return view('admin.mariages.show', compact('mariage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MariageRegister $mariage)
    {
        return view('admin.mariages.form', compact('mariage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MariageRegisterFormRequest $request, MariageRegister $mariage)
    {
        $mariage->update($request->validated());

        return redirect()->route('admin.mariages.show', $mariage)->with('success', 'La fiche du registre a été mise à jour avec succès.');
    }

    // Generate PDF for the specified resource.
    public function generatePdf(MariageRegister $mariage)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.mariages.pdf', compact('mariage'))->setPaper('A4', 'portrait');
        return $pdf->download('mariage_register_' . $mariage->id . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MariageRegister $mariage)
    {
        //
    }
}
