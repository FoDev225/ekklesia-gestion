{{-- MODAL SANCTION DISCIPLINAIRE --}}
@if($believer->exists)
    <div class="modal fade" id="disciplineModal" tabindex="-1" aria-labelledby="disciplineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.believers.applyDiscipline', $believer->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light text-uppercase" id="disciplineModalLabel">Mettre sous sanction disciplinaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Motif de la sanction</label>
                        <input type="text" name="reason" id="reason" class="form-control" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="start_date" class="form-label">Date de début de la sanction</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Date de fin de la sanction</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div> --}}
                    <div class="mb-3">
                        <label for="observations" class="form-label">Observation</label>
                        <textarea name="observations" id="observations" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Confirmer la discipline</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endif

<!-- Modal de la léver de sanction disciplinaire -->
<div class="modal fade" id="releaseDisciplineModal" tabindex="-1" aria-labelledby="releaseDisciplineLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-success">
            <h5 class="modal-title text-light text-uppercase" id="releaseDisciplineLabel">Confirmer la levée de discipline</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Voulez-vous lever la discipline de <strong>{{ $believer->lastname }} {{ $believer->firstname }}</strong> ?</p>
            <p class="text-muted mb-0"><small>Cette action mettra fin à la sanction en cours, mais elle restera visible dans l’historique.</small></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <form action="{{ route('admin.believers.liftDiscipline', $believer->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    Confirmer
                </button>
            </form>
        </div>
    </div>
    </div>
</div>