@extends('layouts.app')

@section('title', 'Détail activité')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <div>
                <strong><i class="fas fa-calendar-day me-2 text-primary"></i>{{ $activity->title }}</strong>
            </div>
            <div class="d-flex gap-2">
                @if($activity->status !== 'completed')
                    <button class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#uploadDocModal">
                        <i class="fas fa-upload me-1"></i> Ajouter document
                    </button>
                @endif

                <a href="{{ route('admin.teams.activities.index', $team) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <p><strong>Modérateur :</strong> {{ $activity->moderator ?? '-' }}</p>
                    <p><strong>Statut :</strong> 
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
                    </p>
                    </p>
                    <p><strong>Date :</strong> {{ $activity->scheduled_date?->format('d/m/Y') ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Thème :</strong> {{ $activity->theme ?? '-' }}</p>

                    {{-- DOCUMENTS --}}
                    @if($activity->documents->count())
                        <div class="d-flex gap-2 flex-wrap mt-2">
                            <strong>Documents :</strong><br>

                            @foreach($activity->documents as $doc)
                                <div class="mt-1">

                                    <a href="{{ asset('storage/' . $doc->file_path) }}"
                                    target="_blank"
                                    class="badge bg-primary text-decoration-none">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        Rapport
                                    </a>

                                    <a href="{{ asset('storage/' . $doc->presence_list_file_path) }}"
                                    target="_blank"
                                    class="badge bg-warning text-dark text-decoration-none">
                                        <i class="fas fa-list me-1"></i>
                                        Présence
                                    </a>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Aucun document ajouté
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Dépenses de l’activité</strong>

            <button class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addExpenseModal">
                <i class="fas fa-plus"></i> Ajouter
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <strong>Total dépensé :</strong>
            <span class="text-warning fw-bold">
                {{ number_format($totalExpenses, 0, ',', ' ') }} FCFA
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($activity->expenses as $expense)
                        <tr>
                            <td>{{ $expense->label }}</td>
                            <td>{{ number_format($expense->amount, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $expense->expense_date?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <form method="POST"
                                    action="{{ route('admin.teams.activities.expenses.destroy', [$team, $activity, $expense]) }}"
                                    onsubmit="return confirm('Supprimer cette dépense ?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Aucune dépense enregistrée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal d'ajout de dépense -->
<div class="modal fade" id="addExpenseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST"
              action="{{ route('admin.teams.activities.expenses.store', [$team, $activity]) }}"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Ajouter une dépense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">

                <div class="col-md-6">
                    <label>Libellé</label>
                    <input type="text" name="label" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Montant</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label>Date</label>
                    <input type="date" name="expense_date" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="uploadDocModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ route('admin.teams.activities.documents.store', [$team, $activity]) }}"
              enctype="multipart/form-data"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Ajouter un document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rapport</label>
                    <input type="file" name="file_path" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Liste de présence</label>
                    <input type="file" name="presence_list_file_path" class="form-control" required>
                </div>

                <input type="hidden" name="uploaded_by" value="{{ auth()->id() }}">

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection