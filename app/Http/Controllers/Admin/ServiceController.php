<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Services;
use App\Models\Periode;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderby('start_date', 'desc')->get();

        $selectedPeriode = $request->periode_id 
            ? Periode::find($request->periode_id) 
            : Periode::where('is_active', true)->first();

        $services = Service::with([
            'assignments.role',
            'assignments.believer',
            'assignments.group'
        ])
        ->where('periode_id', optional($selectedPeriode)->id)
        ->orderBy('service_date')
        ->get();

        return view('admin.services.index', compact('services', 'periodes', 'selectedPeriode'));
    }

    public function create()
    {
        $believers = Believer::where('is_active', true)->get();
        $groups = Group::all();
        $roles = ServiceRole::all();
        $periodes = Periode::orderby('start_date', 'desc')->get();

        return view('admin.services.create', compact('periodes', 'believers', 'groups', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_date' => 'required|date',
            'service_theme' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignments' => 'nullable|array',
        ]);

        // Récupérer la période active
        $periode = Periode::where('is_active', true)->first();

        if (!$periode) {
            return redirect()->back()->with('error', 'Aucune période active trouvée. Veuillez activer une période avant de créer un service.');
        }

        // Créer le culte lié à la période active
        Services::create([
            'periode_id' => $periode->id,
            'service_date' => $data['service_date'],
            'service_theme' => $data['service_theme'],
            'service_type' => $data['service_type'],
            'description' => $data['description'] ?? null,
        ]);

        // 🔥 Assignations
        foreach ($request->assignments ?? [] as $roleId => $assignment) {

            if (!empty($assignment['believer_id']) || !empty($assignment['group_id'])) {

                ServiceAssignment::create([
                    'service_id' => $service->id,
                    'service_role_id' => $roleId,
                    'believer_id' => $assignment['believer_id'] ?? null,
                    'group_id' => $assignment['group_id'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Culte créé avec succès.');
    }
}
