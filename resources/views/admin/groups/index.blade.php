@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 text-gray-800">Gestion des groupes</h1>
            <a href="{{ route('admin.groups.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-1"></i> Nouveau groupe
            </a>
        </div>

        {{-- Stats --}}
        <div class="row mb-4">
            <div class="col-md-4 col-xl-4 mb-3">
                <div class="card border-left-primary shadow-sm h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Nombre total de groupes</p>
                            <h3 class="fw-bold mb-0">{{ $totalGroups }}</h3>
                        </div>
                        <div class="icon-circle bg-primary text-white p-3 rounded-circle">
                            <i class="fas fa-layer-group fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-4 mb-3">
                <div class="card border-left-success shadow-sm h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Attributions aux groupes</p>
                            <h3 class="fw-bold mb-0">{{ $totalAssignments }}</h3>
                        </div>
                        <div class="icon-circle bg-success text-white p-3 rounded-circle">
                            <i class="fas fa-user-check fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-4 mb-3">
                <div class="card border-left-warning shadow-sm h-100 py-2">
                    <div class="card-body">
                        <p class="text-muted mb-2">Top 5 groupes les plus fournis</p>
                        @forelse($topGroups as $top)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $top->name }}</span>
                                <span class="badge bg-warning text-dark">{{ $top->believers_count }}</span>
                            </div>
                        @empty
                            <p class="mb-0 text-muted">Aucune donnée disponible.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Liste des groupes</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du groupe</th>
                                <th>Description</th>
                                <th>Nombre de membres</th>
                                <th width="220">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groups as $i => $group)
                                <tr>
                                    <td>{{ $groups->firstItem() + $i }}</td>
                                    <td class="fw-bold">{{ $group->name }}</td>
                                    <td>{{ $group->description ?: '—' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $group->believers_count }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.groups.show', $group) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce groupe ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun groupe trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $groups->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection