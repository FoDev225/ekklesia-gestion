{{-- MODAL IMPORT BELIEVERS --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="importModal">Importer un fichier excel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.believers.import_excel') }}" method="POST" enctype="multipart/form-data" class="mr-2">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="file" class="form-label" style="color: #000;">Fichier Excel</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="import_mode" class="form-label" style="color: #000;">Mode d'importation</label>
                        </div>
                        <div class="col-md-7">
                            <select name="import_mode" id="import_mode" class="form-control" required>
                                <option value="ignore">Ignorer les fidèles déjà existants</option>
                                <option value="update">Mettre à jour les fidèles existants</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Importer Excel
                    </button>
                </form>
            </div>

            <div class="modal-footer">
                <a href="{{ route('admin.believers.download_import_template') }}" class="btn btn-warning">
                    Télécharger le modèle d'import
                </a>
            </div>
        </div>
    </div>
</div>