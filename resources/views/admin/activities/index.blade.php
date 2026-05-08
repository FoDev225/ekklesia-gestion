@extends('layouts.app')

@section('title', 'Programme d’activités')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">
                    <i class="fas fa-calendar-check me-2 text-primary"></i>
                    Programme d’activités - {{ $team->name }}
                </h4>
                <p class="text-muted mb-0">Gestion des activités annuelles de l’équipe.</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>

                <a href="{{ route('admin.teams.objectives.create', $team) }}"
                    class="btn btn-primary">
                        <i class="fas fa-bullseye me-1"></i>
                        Nouvel objectif annuel
                </a>
            </div>
        </div>

        {{-- KPI INDICATEURS DE PERFORMANCE --}}
        
        {{-- <div class="card shadow-sm border-0 mt-4 mb-4">
            <div class="card-header">
                <strong>Objectifs annuels</strong>
            </div>

            <div class="card-body">

                @forelse($team->objectives as $objective)
                    <div class="border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between">
                            <h5><strong>Année :</strong> {{ $objective->year }}</h5>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.teams.objectives.edit', [$team, $objective]) }}"
                                class="btn btn-sm btn-warning">
                                    Modifier
                                </a>

                                <form method="POST"
                                    action="{{ route('admin.teams.objectives.destroy', [$team, $objective]) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p><strong>Objectif :</strong> {{ $objective->main_goal }}</p>
                        <p><strong>Activités prévues :</strong> {{ $objective->target_activities }}</p>
                        <p><strong>Budget :</strong> {{ number_format($objective->budget_forecast, 0, ',', ' ') }} FCFA</p>

                    </div>
                @empty
                    <p class="text-muted">Aucun objectif défini.</p>
                @endforelse

            </div>
        </div> --}}

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Activités prévues</small>
                        <h3 class="fw-bold">{{ $targetActivities }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Activités réalisées</small>
                        <h3 class="fw-bold text-success">{{ $completedActivities }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Taux de réalisation</small>
                        <h3 class="fw-bold text-primary">{{ $completionRate }}%</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Budget prévisionnel</small>
                        <h4 class="fw-bold">
                            {{ number_format($budgetForecast, 0, ',', ' ') }} FCFA
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small class="text-muted">Budget consommé</small>
                        <h4 class="fw-bold text-warning">
                            {{ number_format($totalExpenses, 0, ',', ' ') }} FCFA
                        </h4>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">

                        <h5 class="mb-4">Progression annuelle</h5>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Réalisation des activités</span>
                                <strong>{{ $completionRate }}%</strong>
                            </div>

                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-primary"
                                    style="width: {{ min($completionRate,100) }}%">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between">
                                <span>Consommation budget</span>
                                <strong>{{ $budgetConsumptionRate }}%</strong>
                            </div>

                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-warning"
                                    style="width: {{ min($budgetConsumptionRate,100) }}%">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">Analyse KPI</h5>
                        <canvas id="teamKpiChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- KPI INDICATEURS DE PERFORMANCE --}}

        <div class="card shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="card-header">
                    <strong>Programme des activités</strong>
                </div>

                <div>
                    <a href="{{ route('admin.teams.activities.annualReport', $team) }}" class="btn btn-warning">
                        <i class="fas fa-file-pdf me-1"></i> Rapport d’activité
                    </a>

                    <a href="{{ route('admin.teams.activities.create', $team) }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Nouvelle activité
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Activité</th>
                            <th>Thème</th>
                            <th>Modérateur</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Statut</th>
                            <th>Documents</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $i => $activity)
                            <tr>
                                <td>{{ $activities->firstItem() + $i }}</td>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->theme ?? '-' }}</td>
                                <td>{{ $activity->moderator ?? '-' }}</td>
                                <td>{{ $activity->scheduled_date?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $activity->location ?? '-' }}</td>
                                <td>
                                    @php
                                        $label = match($activity->status) {
                                            'scheduled' => 'Prévu',
                                            'completed' => 'Terminé',
                                            'canceled'  => 'Annulé',
                                            default => 'Inconnu'
                                        };

                                        $badge = match($activity->status) {
                                            'scheduled' => 'bg-secondary',
                                            'completed' => 'bg-success',
                                            'canceled'  => 'bg-danger',
                                            default => 'bg-dark'
                                        };  
                                    @endphp

                                    <span class="badge {{ $badge }}">{{ $label }}</span>
                                </td>
                                <td>
                                    @forelse($activity->documents as $doc)
                                        <div class="d-flex gap-2 flex-wrap mb-1">
                                            <!-- Rapport -->
                                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf fa-lg"></i> Rapport
                                            </a>

                                            <!-- Liste de présence -->
                                            <a href="{{ asset('storage/' . $doc->presence_list_file_path) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-users fa-lg"></i> Présence
                                            </a>
                                        </div>

                                    @empty
                                        <span class="text-muted small">Aucun document</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('admin.teams.activities.show', [$team, $activity]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.teams.activities.edit', [$team, $activity]) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.teams.activities.destroy', [$team, $activity]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette activité ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Aucune activité enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        new Chart(document.getElementById('teamKpiChart'), {
            type: 'bar',
            data: {
                labels: [
                    'Activités prévues',
                    'Activités réalisées',
                    'Budget prévu',
                    'Budget consommé'
                ],
                datasets: [{
                    label: 'Valeurs',
                    data: [
                        {{ $targetActivities }},
                        {{ $completedActivities }},
                        {{ $budgetForecast }},
                        {{ $totalExpenses }}
                    ],
                    backgroundColor: [
                        '#3A9BDC',
                        '#198754',
                        '#C9A635',
                        '#dc3545'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>

@endsection