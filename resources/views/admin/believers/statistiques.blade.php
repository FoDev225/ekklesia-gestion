@extends('layouts.app')

@section('title', 'Tableau de bord')

    @section('styles')
        <style>
            body {
                background: #f5f7fb;
            }

            .dashboard-title {
                font-weight: 700;
                color: #2c3e50;
            }

            .dashboard-subtitle {
                color: #6c757d;
                font-size: 0.95rem;
            }

            .stat-card,
            .chart-card {
                border-radius: 20px;
                transition: all 0.3s ease;
                animation: fadeUp 0.6s ease;
                background: #fff;
            }

            .stat-card:hover,
            .chart-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 30px rgba(0,0,0,0.08) !important;
            }

            .chart-title {
                color: #4b6ee8;
                font-weight: 500;
                font-size: 1.8rem;
            }

            .icon-circle {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .bg-primary-soft { background: rgba(58, 155, 220, 0.15); }
            .bg-success-soft { background: rgba(25, 135, 84, 0.15); }
            .bg-info-soft    { background: rgba(13, 202, 240, 0.15); }
            .bg-warning-soft { background: rgba(201, 166, 53, 0.18); }
            .bg-danger-soft  { background: rgba(220, 53, 69, 0.15); }

            .mini-stat {
                border-radius: 16px;
                background: #f8f9fa;
                border: 1px solid #ececec;
                padding: 16px;
                transition: all 0.3s ease;
            }

            .mini-stat:hover {
                background: #ffffff;
                transform: scale(1.01);
            }

            .progress {
                border-radius: 20px;
                overflow: hidden;
            }

            canvas {
                max-width: 100%;
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(15px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endsection

    @section('content')
        <div class="container-fluid py-4">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="dashboard-title mb-1">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        Tableau de bord
                    </h1>
                    <p class="dashboard-subtitle mb-0">
                        Vue statistique de l'ensemble de la communauté.
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.believers.index') }}" class="btn btn-warning shadow-sm">
                        Liste des fidèles
                    </a>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="row g-4 mb-4">

                <!-- Total fidèles -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Total fidèles</p>
                                <h2 class="fw-bold mb-0">{{ $totalBelievers }}</h2>
                            </div>
                            <div class="icon-circle bg-primary-soft">
                                <i class="fas fa-users text-primary fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actifs -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Fidèles actifs</p>
                                <h2 class="fw-bold mb-0">{{ $activeBelievers }}</h2>
                            </div>
                            <div class="icon-circle bg-success-soft">
                                <i class="fas fa-user-check text-success fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inactifs -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Fidèles inactifs</p>
                                <h2 class="fw-bold mb-0">{{ $inactiveBelievers }}</h2>
                            </div>
                            <div class="icon-circle bg-danger-soft">
                                <i class="fas fa-user-slash text-danger fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Taux baptême -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Taux de baptême</p>
                                <h2 class="fw-bold mb-0">{{ $baptismRate }}%</h2>
                                <small class="text-muted">{{ $baptisedCount }} baptisé(s)</small>
                            </div>
                            <div class="icon-circle bg-info-soft">
                                <i class="fas fa-water text-info fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Discipline -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Taux de discipline</p>
                                <h2 class="fw-bold mb-0">{{ $disciplineRate }}%</h2>
                                <small class="text-muted">{{ $disciplineCount }} sous discipline</small>
                            </div>
                            <div class="icon-circle bg-warning-soft">
                                <i class="fas fa-balance-scale text-warning fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Départs -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Nombre de départs</p>
                                <h2 class="fw-bold mb-0">{{ $departuresCount }}</h2>
                            </div>
                            <div class="icon-circle bg-warning-soft">
                                <i class="fas fa-right-from-bracket text-danger fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Décès -->
                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Nombre de décès</p>
                                <h2 class="fw-bold mb-0">{{ $deceasedCount }}</h2>
                            </div>
                            <div class="icon-circle bg-warning-soft">
                                <i class="fas fa-cross text-dark fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xl-3">
                    <div class="card stat-card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Top groupes les plus fournis</p>
                                <h2 class="fw-bold mb-0">{{ $topGroups->count() }}</h2>
                            </div>
                            <div class="icon-circle bg-warning-soft">
                                <i class="fas fa-layer-group text-primary fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Charts -->
            <div class="row g-4">

                <!-- Répartition par sexe -->
                <div class="col-lg-6">
                    <div class="card chart-card shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-venus-mars me-2 text-primary"></i>
                                Répartition par sexe
                            </h2>
                            <canvas id="genderChart" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Statut matrimonial -->
                <div class="col-lg-6">
                    <div class="card chart-card shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-ring me-2 text-warning"></i>
                                Statut matrimonial
                            </h2>
                            <canvas id="maritalChart" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Évolution des inscriptions -->
                <div class="col-lg-8">
                    <div class="card chart-card shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                Évolution des inscriptions
                            </h2>
                            <canvas id="registrationChart" height="120"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top 5 langues -->
                <div class="col-lg-4">
                    <div class="card chart-card shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-language me-2 text-warning"></i>
                                Top 5 langues
                            </h2>
                            <canvas id="languageChart" height="220"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tranches d'âge -->
                <div class="col-lg-6">
                    <div class="card chart-card shadow-sm border-0">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-user-clock me-2 text-primary"></i>
                                Répartition par tranche d’âge
                            </h2>
                            <canvas id="ageChart" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm border-0 chart-card">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-users me-2 text-primary"></i>
                                Membres par groupe
                            </h2>
                            <canvas id="groupsChart" height="180"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Vue rapide -->
                <div class="col-lg-6">
                    <div class="card chart-card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h2 class="chart-title mb-4">
                                <i class="fas fa-chart-pie me-2 text-warning"></i>
                                Vue rapide
                            </h2>

                            <div class="d-flex flex-column gap-3">
                                <div class="mini-stat">
                                    <div class="d-flex justify-content-between">
                                        <span>Baptisés</span>
                                        <strong>{{ $baptismRate }}%</strong>
                                    </div>
                                    <div class="progress mt-2" style="height: 10px;">
                                        <div class="progress-bar" style="width: {{ $baptismRate }}%; background-color: #3A9BDC;"></div>
                                    </div>
                                </div>

                                <div class="mini-stat">
                                    <div class="d-flex justify-content-between">
                                        <span>Sous discipline</span>
                                        <strong>{{ $disciplineRate }}%</strong>
                                    </div>
                                    <div class="progress mt-2" style="height: 10px;">
                                        <div class="progress-bar" style="width: {{ $disciplineRate }}%; background-color: #C9A635;"></div>
                                    </div>
                                </div>

                                <div class="mini-stat">
                                    <div class="d-flex justify-content-between">
                                        <span>Fidèles inactifs</span>
                                        <strong>{{ $inactiveBelievers }}</strong>
                                    </div>
                                </div>

                                <div class="mini-stat">
                                    <div class="d-flex justify-content-between">
                                        <span>Total communauté</span>
                                        <strong>{{ $totalBelievers }}</strong>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const blue = '#3A9BDC';
            const gold = '#C9A635';

            // Répartition par sexe
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($genderStats->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($genderStats->values()) !!},
                        backgroundColor: [blue, gold, '#6c757d', '#17a2b8']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Statut matrimonial
            new Chart(document.getElementById('maritalChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($maritalStatusStats->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($maritalStatusStats->values()) !!},
                        backgroundColor: [blue, gold, '#6c757d', '#17a2b8', '#198754']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Évolution des inscriptions
            new Chart(document.getElementById('registrationChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($registrationStats->keys()) !!},
                    datasets: [{
                        label: 'Inscriptions',
                        data: {!! json_encode($registrationStats->values()) !!},
                        borderColor: blue,
                        backgroundColor: 'rgba(58, 155, 220, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: gold
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Top 5 langues
            new Chart(document.getElementById('languageChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topLanguages->keys()) !!},
                    datasets: [{
                        label: 'Nombre',
                        data: {!! json_encode($topLanguages->values()) !!},
                        backgroundColor: [blue, gold, blue, gold, blue],
                        borderRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Tranches d'âge
            new Chart(document.getElementById('ageChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($ageStats)) !!},
                    datasets: [{
                        label: 'Nombre de fidèles',
                        data: {!! json_encode(array_values($ageStats)) !!},
                        backgroundColor: [blue, gold, blue, gold],
                        borderRadius: 12
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Membres par groupe
            const groupsChart = document.getElementById('groupsChart');

            if (groupsChart) {
                new Chart(groupsChart, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($groupsStats->pluck('name')->values()) !!},
                        datasets: [{
                            label: 'Nombre de membres',
                            data: {!! json_encode($groupsStats->pluck('believers_count')->values()) !!},
                            backgroundColor: '#3A9BDC',
                            borderColor: '#C9A635',
                            borderWidth: 1,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            duration: 1200
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection