<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\Periode;
use App\Models\Believer;
use App\Models\Group;
use App\Models\ServiceRole;
use App\Models\ServiceAssignment;

use App\Helpers\ServiceAssignmentHelper;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $groups = Group::where('type_gp', 'worship')->get();
        $roles = ServiceRole::all();
        $periodes = Periode::orderby('start_date', 'desc')->get();

        return view('admin.services.form', compact('periodes', 'believers', 'groups', 'roles'));
    }

    public function store(Request $request)
    {
       //dd($request->all());
        $request->validate([
            'periode.name' => 'required|string',
            'periode.general_theme' => 'required|string',
            'periode.start_date' => 'required|date',
            'periode.end_date' => 'required|date|after:periode.start_date',
            'services' => 'required|array|min:1',
            'services.*.date' => 'required|date',
        ]);

        try {

            DB::transaction(function () use ($request) {

                // Charger les rôles une seule fois
                $roles = ServiceRole::pluck('id', 'code');

                // 1. Création période
                $periode = Periode::create([
                    'name' => $request->periode['name'],
                    'general_theme' => $request->periode['general_theme'] ?? null,
                    'start_date' => $request->periode['start_date'],
                    'end_date' => $request->periode['end_date'],
                    'is_active' => $request->boolean('periode.is_active'),
                ]);

                // Désactiver les autres périodes
                Periode::where('id', '!=', $periode->id)
                    ->update(['is_active' => false]);

                // 2. Création des services
                foreach ($request->services as $serviceData) {

                    $service = Service::create([
                        'service_date' => $serviceData['date'],
                        'service_theme' => $serviceData['theme'] ?? null,
                        'service_type' => $serviceData['type'] ?? null,
                        'periode_id' => $periode->id
                    ]);

                    // Assignations avec helper

                    // Prédicateur
                    ServiceAssignmentHelper::assign($service, 'preacher', $serviceData['preacher_main'] ?? null, null, false);
                    ServiceAssignmentHelper::assign($service, 'preacher', $serviceData['preacher_backup'] ?? null, null, true);

                    // Président
                    ServiceAssignmentHelper::assign($service, 'president', $serviceData['president_main'] ?? null, null, false);
                    ServiceAssignmentHelper::assign($service, 'president', $serviceData['president_backup'] ?? null, null, true);

                    // Annonces
                    ServiceAssignmentHelper::assign($service, 'announcements', $serviceData['announcements'] ?? null);

                    // Louange (groupes multiples)
                    foreach ($serviceData['worship_groups'] ?? [] as $groupId) {
                        ServiceAssignmentHelper::assign($service, 'worship', null, $groupId);
                    }
                }
            });

            return redirect()->route('admin.services.index')->with('success', 'Programme créé avec succès');

        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('error', $e->getMessage());
        }
    }

    public function calendar(Request $request)
    {
        $selectedPeriode = $request->periode_id 
            ? \App\Models\Periode::find($request->periode_id)
            : \App\Models\Periode::where('is_active', true)->first();

        $services = \App\Models\Service::where('periode_id', optional($selectedPeriode)->id)
            ->get();

        $events = $services->map(function ($service) {

            $assignments = $service->assignments;

            $preacher = optional(
                $assignments->firstWhere('role.code', 'preacher')
            )->believer->firstname ?? 'N/A';

            $groups = $assignments
                ->where('role.code', 'worship')
                ->map(fn($a) => $a->group->name)
                ->implode(', ');

            // 🎨 COULEUR
            $color = match($service->service_type) {
                'Culte commun' => '#198754', // vert bootstrap
                'Culte séparé' => '#ffc107', // warning
                default => '#6c757d'
            };

            return [
                'id' => $service->id,
                'title' => $service->service_theme ?? 'Culte',
                'start' => $service->service_date,

                // 🔥 INFOS CUSTOM
                'extendedProps' => [
                    'preacher' => $preacher,
                    'groups' => $groups,
                ],

                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        });

        $nextSunday = Carbon::now()->next(Carbon::SUNDAY);

        $nextService = Service::with([
            'assignments.role',
            'assignments.believer',
            'assignments.group'
        ])->where('periode_id', optional($selectedPeriode)->id)
            ->whereDate('service_date', $nextSunday)
            ->first();
        
        // Génération du message WhatsApp pour le prochain culte
            
        $message = \App\Services\ServiceMessageGenerator::generate();

        // $whatsappUrl = $message 
        //     ? 'https://api.whatsapp.com/send?text=' . urlencode($message) 
        //     : null;
        
        $whatsappUrl = $message
            ? "https://wa.me/?text=" . urlencode($message)
            : null;

        return view('admin.services.calendar', compact(
            'events', 
            'selectedPeriode', 
            'services', 
            'nextService',
            'message', 
            'whatsappUrl', 
            'nextSunday'
        ));
    }

    public function updateDate(Request $request, Service $service)
    {
        $service->update([
            'service_date' => $request->date
        ]);

        return response()->json(['success' => true]);
    }

    // Program Export in PDF format
    public function exportPdf(Request $request)
    {
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

        $pdf = Pdf::loadView('admin.services.pdf', [
            'services' => $services,
            'selectedPeriode' => $selectedPeriode
        ])->setPaper('A4', 'landscape');

        return $pdf->download('programme-cultes.pdf');
    }
}
