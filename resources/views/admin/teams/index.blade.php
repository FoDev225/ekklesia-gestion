@extends('layouts.app')

@section('title', 'Liste des équipes')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-dark fw-bold">
                <i class="fas fa-users-cog me-2 text-primary"></i>
                Liste des équipes
            </h1>

            <a href="{{ route('admin.teams.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Nouvelle équipe
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Objectif</th>
                                <th>Statut</th>
                                <th>Membres</th>
                                <th width="220">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teams as $i => $team)
                                <tr>
                                    <td>{{ $teams->firstItem() + $i }}</td>
                                    <td class="fw-semibold">{{ $team->name }}</td>
                                    <td>{{ $team->objectif ?? '-' }}</td>
                                    <td>
                                        @if($team->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $team->believers_count }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Supprimer cette équipe ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Aucune équipe trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection