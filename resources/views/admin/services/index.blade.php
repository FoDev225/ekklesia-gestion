@extends('layouts.app')

@section('title', 'Programme de cultes')

<style>
    table td {
        vertical-align: middle;
        font-size: 14px;
    }

    table th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge {
        font-size: 11px;
    }
</style>

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 text-dark fw-bold">
                    <i class="fas fa-users-cog me-2 text-primary"></i>
                    Programme de cultes
                </h1>
            </div>
            <div class="d-flex gap-2">
                <bouton type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createPeriodeModal">
                    <i class="fas fa-plus me-1"></i> Créer la période
                </bouton>

                <a href="{{ route('admin.services.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-1"></i> Nouveau programme
                </a>
            </div>
        </div>

         @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

         @if(session('error'))
             <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white">
                    THEME : <strong>{{ $selectedPeriode->general_theme ?? 'Aucun thème actif' }}</strong><br>
                    PERIODE : <strong>De {{ $selectedPeriode->name ?? 'Aucune période active' }}</strong>
                </h6>
                <div>
                    <a href="{{ route('admin.services.pdf') }}" class="btn btn-warning">
                        <i class="fas fa-file-pdf me-1"></i> Programme PDF
                    </a>
                    <a href="" class="btn btn-info">
                        <i class="fas fa-file-excel me-1"></i> Programme Excel
                    </a>
                    <a href="{{ route('admin.services.calendar') }}" class="btn btn-light">
                        <i class="fas fa-calendar-alt me-1"></i> Vue calendrier
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Thème</th>
                            <th>Prédicateur</th>
                            <th>Président</th>
                            <th>Louange</th>
                            <th>Annonces</th>
                            <th>Type</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($services as $service)

                            @php
                                $assignments = $service->assignments;
                            @endphp

                            <tr>
                                <td>
                                    <strong>{{ $service->service_date->format('d/m/Y') }}</strong>
                                </td>

                                <td>{{ $service->service_theme ?? '-' }}</td>

                                {{-- PRÉDICATEUR --}}
                                <td>
                                    @php
                                        $main = $assignments->firstWhere('role.code','preacher');
                                        $backup = $assignments->where('role.code','preacher')->where('is_backup', true)->first();
                                    @endphp

                                    <span class="fw-bold text-dark">
                                        {{ $main->believer->firstname ?? '-' }} {{ $main->believer->lastname ?? '-' }}
                                    </span>

                                    @if($backup)
                                        <br>
                                        <small class="text-warning">
                                            (Suppléant : {{ $backup->believer->firstname }} {{ $backup->believer->lastname }})
                                        </small>
                                    @endif
                                </td>

                                {{-- PRÉSIDENT --}}
                                <td>
                                    @php
                                        $main = $assignments->firstWhere('role.code','president');
                                        $backup = $assignments->where('role.code','president')->where('is_backup', true)->first();
                                    @endphp

                                    <span class="fw-bold text-dark">
                                        {{ $main->believer->firstname ?? '-' }} {{ $main->believer->lastname ?? '-' }}
                                    </span>

                                    @if($backup)
                                        <br>
                                        <small class="text-warning">
                                            (Suppléant : {{ $backup->believer->firstname }} {{ $backup->believer->lastname }})
                                        </small>
                                    @endif
                                </td>

                                {{-- LOUANGE MULTI --}}
                                <td>
                                    @foreach($assignments->where('role.code','worship') as $a)
                                        <span class="badge bg-primary mb-1">
                                            {{ $a->group->name }}
                                        </span>
                                    @endforeach
                                </td>

                                {{-- ANNONCES --}}
                                <td>
                                    @php
                                        $announcer = $assignments->firstWhere('role.code','announcements');
                                    @endphp

                                    @if($announcer && $announcer->believer)
                                        <span class="text-dark fw-bold">
                                            {{ $announcer->believer->firstname }} {{ $announcer->believer->lastname }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $service->service_type == 'special' ? 'warning' : 'secondary' }}">
                                        {{ ucfirst($service->service_type) }}
                                    </span>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createPeriodeModal" tabindex="-1" aria-labelledby="createPeriodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="createPeriodeModalLabel">Thème Général</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.periodes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label style="color: #000;">Période</label>
                            <input type="text" name="periode[name]" class="form-control"
                                value="{{ old('periode.name') }}"
                                placeholder="Juin - Septembre 2026">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label style="color: #000;">Date début</label>
                            <input type="date" name="periode[start_date]" class="form-control"
                                value="{{ old('periode.start_date') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label style="color: #000;">Date fin</label>
                            <input type="date" name="periode[end_date]" class="form-control"
                                value="{{ old('periode.end_date') }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label style="color: #000;">Thème général</label>
                            <input type="text" name="periode[general_theme]" class="form-control"
                                value="{{ old('periode.general_theme') }}">
                        </div>

                        <div class="col-md-8 d-flex align-items-center">
                            <label style="color: #000;" for="activeSwitch">Activer le programme :</label>
                            <div class="form-check form-switch ml-5">
                                <input class="form-check-input" type="checkbox" name="periode[is_active]" id="activeSwitch"
                                    {{ old('periode.is_active') ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>
            </div>
            </div>
        </div>
    </div>

@endsection