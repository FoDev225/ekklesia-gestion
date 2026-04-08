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

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisquesController extends Controller
{
    public function index()
    {
        // =========================
        // CARTES STATS
        // =========================
        $totalBelievers = Believer::count();
        $activeBelievers = Believer::where('is_active', true)->count();
        $inactiveBelievers = Believer::where('is_active', false)->count();

        $departuresCount = BelieverDeparture::where('type', 'quit')->count();
        $deceasedCount = BelieverDeparture::where('type', 'deceased')->count();

        // =========================
        // REPARTITION HOMME / FEMME
        // =========================
        $genderStats = Believer::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        // =========================
        // STATUT MATRIMONIAL
        // =========================
        $maritalStatusStats = Believer::select('marital_status', DB::raw('count(*) as total'))
            ->groupBy('marital_status')
            ->pluck('total', 'marital_status');

        // =========================
        // EVOLUTION DES INSCRIPTIONS PAR MOIS
        // =========================
        $registrationStats = Believer::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // =========================
        // TOP LANGUES
        // =========================
        $topLanguages = DB::table('believer_languages')
            ->join('languages', 'believer_languages.language_id', '=', 'languages.id')
            ->select('languages.name', DB::raw('count(*) as total'))
            ->groupBy('languages.name')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'name');
        
        // =========================
        // TAUX DE BAPTEME
        // =========================
        $baptisedCount = Believer::whereHas('churchInformation', function ($q) {
            $q->where('baptised', 'Oui');
        })->count();
        $unbaptisedCount = Believer::whereHas('churchInformation', function ($q) {
            $q->where('baptised', 'Non');
        })->count();
        $baptismRate = $totalBelievers > 0 ? round(($baptisedCount / $totalBelievers) * 100) : 0;

        // =========================
        // TAUX DE DISCIPLINE
        // =========================
        $disciplineCount = Believer::whereHas('disciplinarySituations', function ($q) {
            $q->where('status', 'active');
        })->count();
        $disciplineRate = $totalBelievers > 0 ? round(($disciplineCount / $totalBelievers) * 100) : 0;

        // ===== TRANCHE D'AGE =====
        $believers = Believer::whereNotNull('birth_date')->get();
        $ageStats = [
            'Nourrisson (0-2)' => 0,
            'Pré-scolaire (3-4)' => 0,
            'ECODIM (5-18)' => 0,
            'Jeune (19-40)' => 0,
            'Adulte (41+)' => 0,
        ];

        foreach ($believers as $believer) {
            $age = $believer->age;

            if (is_null($age)) {
                continue;
            }

            if ($age <= 2) {
                $ageStats['Nourrisson (0-2)']++;
            } elseif ($age <= 4) {
                $ageStats['Pré-scolaire (3-4)']++;
            } elseif ($age <= 18) {
                $ageStats['ECODIM (5-18)']++;
            } elseif ($age <= 40) {
                $ageStats['Jeune (19-40)']++;
            } else {
                $ageStats['Adulte (41+)']++;
            }
        }

        // ===== STATS GROUPES =====
        $groupsStats = Group::withCount('believers')
            ->orderByDesc('believers_count')
            ->get();

        $topGroups = Group::withCount('believers')
            ->orderByDesc('believers_count')
            ->take(5)
            ->get();

        return view('admin.believers.statistiques', compact(
            'totalBelievers',
            'activeBelievers',
            'inactiveBelievers',
            'baptisedCount',
            'unbaptisedCount',
            'disciplineCount',
            'departuresCount',
            'deceasedCount',
            'genderStats',
            'maritalStatusStats',
            'registrationStats',
            'topLanguages',
            'baptismRate',
            'disciplineRate',
            'ageStats',
            'groupsStats',
            'topGroups'
        ));
    }
}
