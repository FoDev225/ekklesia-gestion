<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChurchInfo;
use App\Http\Requests\ChurchInfoFormRequest;

class ChurchInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $churchInfo = ChurchInfo::paginate();
        return view('admin.church_info.index', compact('churchInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $church_info = new ChurchInfo();
        return view('admin.church_info.form', compact('church_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChurchInfoFormRequest $request)
    {
        $data = $request->validated();
        // Gestion de la photo
        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path'); 
            $filename = time() . '.' . $file->extension();
            $path = $file->storeAs('church_photos', $filename, 'public');
            $data['photo_path'] = $path;
        }

        $church = ChurchInfo::create($data);

        return redirect()->route('admin.church_info.show', $church->id)->with('success', 'Les informations de l\'église ont été créées avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChurchInfo $church_info)
    {
        return view('admin.church_info.show', compact('church_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChurchInfo $church_info)
    {
        return view('admin.church_info.form', compact('church_info'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChurchInfoFormRequest $request, ChurchInfo $church_info)
    {
        $data = $request->validated();

        // Si une nouvelle image est envoyée
        if ($request->hasFile('photo_path')) {

            // Supprimer l'ancienne image si elle existe
            if ($church_info->photo_path && \Storage::disk('public')->exists($church_info->photo_path)) {
                \Storage::disk('public')->delete($church_info->photo_path);
            }

            // Enregistrer la nouvelle image
            $filename = time() . '.' . $file->extension();
            $path = $file->storeAs('church_photos', $filename, 'public');
            $data['photo_path'] = $path;
        }

        // Mise à jour
        $church_info->update($data);
        
        return redirect()->route('admin.church_info.show', $church_info->id)->with('success', 'Les informations de l\'église ont été mises à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
