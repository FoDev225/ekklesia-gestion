@extends('layouts.app')

@section('title', 'Détail groupe')

@section('content')
<div class="container-fluid">

    {{-- TITRE --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">{{ $group->name }}</h1>
            <p class="mb-0 text-muted">{{ $group->description ?? 'Aucune description disponible.' }}</p>
        </div>
        <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">
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
            {{-- <form method="GET" action="{{ route('admin.groups.show', $group) }}">
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
                {{-- <a href="{{ route('admin.groups.show', $group) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-rotate-left me-1"></i> Réinitialiser
                </a> --}}

                <a href="{{ route('admin.groups.exportExcel', array_merge(['group' => $group->id], request()->only('search', 'gender', 'role'))) }}"
                class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>

                <a href="{{ route('admin.groups.exportPdf', array_merge(['group' => $group->id], request()->only('search', 'gender', 'role'))) }}"
                class="btn btn-danger">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
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
                    <form action="{{ route('admin.groups.assignBeliever', $group) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Fidèle</label>
                            <select name="believer_id" class="form-select @error('believer_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un fidèle --</option>
                                @foreach($availableBelievers as $believer)
                                    <option value="{{ $believer->id }}" {{ old('believer_id') == $believer->id ? 'selected' : '' }}>
                                        {{ $believer->lastname }} {{ $believer->firstname }}
                                        @if($believer->phone_number ?? false)
                                            - {{ $believer->phone_number }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('believer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rôle dans le groupe</label>
                            <input type="text"
                                   name="role"
                                   class="form-control @error('role') is-invalid @enderror"
                                   value="{{ old('role') }}"
                                   placeholder="Ex: Responsable, Chantre, Membre...">
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date d’intégration</label>
                            <input type="date"
                                   name="joined_at"
                                   class="form-control @error('joined_at') is-invalid @enderror"
                                   value="{{ old('joined_at') }}">
                            @error('joined_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check-circle me-1"></i> Attribuer
                        </button>
                    </form>
                </div>
            </div>

            {{-- STATS RAPIDES --}}
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Infos du groupe
                    </h5>
                    <p class="mb-2">
                        <strong>Nombre de membres :</strong>
                        <span class="badge bg-success">{{ $group->believers->count() }}</span>
                    </p>
                    <p class="mb-0">
                        <strong>Description :</strong><br>
                        {{ $group->description ?? 'Non renseignée' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- LISTE DES MEMBRES --}}
        <div class="col-lg-9 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <strong><i class="fas fa-users me-2 text-primary"></i>Membres du groupe</strong>
                </div>
                <div class="card-body">
                    @if($members->isEmpty())
                        <div class="alert alert-info mb-0">
                            Aucun fidèle n’est encore affecté à ce groupe.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Sexe</th>
                                        <th>Rôle</th>
                                        <th>Date d’intégration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $i => $believer)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <strong>{{ $believer->lastname }} {{ $believer->firstname }}</strong>
                                            </td>
                                            <td>
                                                @if($believer->gender === 'Masculin')
                                                    <span class="badge bg-primary">M</span>
                                                @elseif($believer->gender === 'Féminin')
                                                    <span class="badge bg-danger">F</span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($believer->pivot->role)
                                                    <span class="badge bg-info text-dark">{{ $believer->pivot->role }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Non défini</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $believer->pivot->joined_at ? \Carbon\Carbon::parse($believer->pivot->joined_at)->format('d/m/Y') : 'Non renseignée' }}
                                            </td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-danger open-remove-modal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#removeBelieverModal"
                                                        data-action="{{ route('admin.groups.removeBeliever', [$group, $believer]) }}"
                                                        data-name="{{ $believer->lastname }} {{ $believer->firstname }}">
                                                    <i class="fas fa-user-minus me-1"></i> Retirer
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $members->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Retirer un fidèle -->
<div class="modal fade" id="removeBelieverModal" tabindex="-1" aria-labelledby="removeBelieverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="removeBelieverModalLabel">
                    <i class="fas fa-user-minus me-2"></i> Retirer du groupe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2" style="color: #000;">
                    Voulez-vous vraiment retirer ce fidèle du groupe ?
                </p>
                <p class="fw-bold text-danger mb-0" id="believerNameToRemove"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Annuler
                </button>

                <form id="removeBelieverForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Oui, retirer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection