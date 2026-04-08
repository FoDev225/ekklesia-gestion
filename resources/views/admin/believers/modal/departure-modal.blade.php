{{-- MODAL SANCTION DISCIPLINAIRE --}}
@if($believer->exists)
    <div class="modal fade" id="quitterModal" tabindex="-1" aria-labelledby="quitterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.believers.leave', $believer->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light text-uppercase" id="quitterModalLabel">Quitter la communauté</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="departure_date" class="form-label">Date</label>
                        <input type="date" name="departure_date" id="departure_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Depart</label>
                        <select name="type" id="type" class="form-control">
                            <option value="">-- Sélectionner --</option>
                                <option value="quit">Quitter la communauté</option>
                                <option value="deceased">Décéder</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Motif du départ</label>
                        <input type="text" name="reason" id="reason" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Observation</label>
                        <textarea name="comment" id="comment" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Confirmer le depart</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endif

<!-- Modal de la léver de sanction disciplinaire -->
<div class="modal fade" id="quitterModalLabel" tabindex="-1" aria-labelledby="quitterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-success">
            <h5 class="modal-title text-light text-uppercase" id="quitterModalLabel">Confirmer la réintégration</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Voulez-vous réintegrer le fidèle <strong>{{ $believer->lastname }} {{ $believer->firstname }}</strong> ?</p>
            <p class="text-muted mb-0"><small>Cette action réintègre le fidèle dans la communauté.</small></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <form action="{{ route('admin.believers.reintegrate', $believer->id) }}" method="POST" class="d-inline">
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