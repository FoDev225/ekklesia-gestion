@extends('layouts.app')

@section('title', 'Détail équipe')

@section('content')

<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">{{ $team->name }}</h1>
            <p class="mb-0 text-muted">{{ $team->description ?? 'Aucune description disponible.' }}</p>
        </div>
        
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    {{-- ALERTES --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning shadow-sm">{{ session('warning') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <strong><i class="fas fa-filter me-2 text-primary"></i>Exports de la liste du groupe</strong>
        </div>
        <div class="card-body">
            {{-- <form method="GET" action="{{ route('admin.teams.show', $team) }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Recherche</label>
                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Nom ou prénom"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Sexe</label>
                        <select name="gender" class="form-select">
                            <option value="">-- Tous --</option>
                            <option value="Masculin" {{ request('gender') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                            <option value="Féminin" {{ request('gender') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Filtrer
                        </button>
                    </div>
                </div>
            </form> --}}

            {{-- <hr class="my-4"> --}}

            <div class="d-flex flex-wrap gap-2">
                {{-- <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-rotate-left me-1"></i> Réinitialiser
                </a> --}}

                <a href="{{ route('admin.teams.exportExcel', array_merge(['team' => $team->id], request()->only('search', 'gender'))) }}"
                class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>

                <a href="{{ route('admin.teams.exportPdf', array_merge(['team' => $team->id], request()->only('search', 'gender'))) }}"
                class="btn btn-danger">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total activités</p>
                        <h3 class="fw-bold mb-0">{{ $activitiesStats['total'] }}</h3>
                    </div>
                    <div class="icon-circle bg-primary-soft">
                        <i class="fas fa-calendar-alt text-primary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Prévues</p>
                        <h3 class="fw-bold mb-0">{{ $activitiesStats['scheduled'] }}</h3>
                    </div>
                    <div class="icon-circle bg-warning-soft">
                        <i class="fas fa-clock text-warning fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Réalisées</p>
                        <h3 class="fw-bold mb-0">{{ $activitiesStats['completed'] }}</h3>
                    </div>
                    <div class="icon-circle bg-success-soft">
                        <i class="fas fa-check-circle text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Annulées</p>
                        <h3 class="fw-bold mb-0">{{ $activitiesStats['canceled'] }}</h3>
                    </div>
                    <div class="icon-circle bg-danger-soft">
                        <i class="fas fa-times-circle text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        {{-- FORMULAIRE D’ATTRIBUTION --}}
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <strong><i class="fas fa-user-plus me-2"></i>Attribuer un fidèle</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.teams.assignBeliever', $team) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Fidèle</label>
                            <select name="believer_id" class="form-control @error('believer_id') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach($availableBelievers as $believer)
                                    <option value="{{ $believer->id }}">
                                        {{ $believer->lastname }} {{ $believer->firstname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('believer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <input type="text" name="role" class="form-control" placeholder="Ex : Responsable, Membre...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date d’intégration</label>
                            <input type="date" name="joined_at" class="form-control">
                        </div>

                        <button class="btn btn-success w-100">
                            <i class="fas fa-user-check me-1"></i> Attribuer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- LISTE DES MEMBRES --}}
        <div class="col-lg-9 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3 d-sm-flex align-items-center justify-content-between">
                    <h6><i class="fas fa-users me-2"></i>Membres de l’équipe</h6>

                    <a href="{{ route('admin.teams.activities.index', $team) }}" class="btn btn-primary">
                        <i class="fas fa-calendar-check me-1"></i> Gérer les activités annuelles
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Sexe</th>
                                    <th>Contact</th>
                                    <th>Rôle</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($team->believers as $i => $believer)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $believer->lastname }} {{ $believer->firstname }}</td>
                                        <td>
                                            @if($believer->gender === 'Masculin')
                                                <span class="badge bg-primary">M</span>
                                            @elseif($believer->gender === 'Féminin')
                                                <span class="badge bg-danger">F</span>
                                            @else
                                                <span class="badge bg-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $believer->address->whatsapp_number ?? '-' }}</td>
                                        <td>{{ $believer->pivot->role ?? '-' }}</td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger open-remove-modal"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#removeBelieverModal"
                                                    data-url="{{ route('admin.teams.removeBeliever', [$team, $believer]) }}"
                                                    data-believer="{{ $believer->lastname }} {{ $believer->firstname }}"
                                                    data-team="{{ $team->name }}">
                                                <i class="fas fa-user-minus me-1"></i> Retirer
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            Aucun fidèle attribué à cette équipe.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Retrait fidèle -->
<div class="modal fade" id="removeBelieverModal" tabindex="-1" aria-labelledby="removeBelieverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title" id="removeBelieverModalLabel">
                    <i class="fas fa-user-minus me-2"></i>Retirer un fidèle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2 text-dark">
                    Voulez-vous vraiment retirer
                    <strong id="removeBelieverName"></strong>
                    de l’équipe
                    <strong id="removeTeamName"></strong> ?
                </p>

                <div class="alert alert-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cette action supprimera l’attribution du fidèle à cette équipe.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                    Annuler
                </button>

                <form id="removeBelieverForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-user-minus me-1"></i> Confirmer le retrait
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const removeButtons = document.querySelectorAll('.open-remove-modal');
            const removeForm = document.getElementById('removeBelieverForm');
            const believerName = document.getElementById('removeBelieverName');
            const teamName = document.getElementById('removeTeamName');

            removeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const url = this.dataset.url;
                    const believer = this.dataset.believer;
                    const team = this.dataset.team;

                    removeForm.setAttribute('action', url);
                    believerName.textContent = believer;
                    teamName.textContent = team;
                });
            });
        });
    </script>
@endsection