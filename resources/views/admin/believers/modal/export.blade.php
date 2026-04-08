@php
    $categories = \App\Models\BelieversCategory::all();
@endphp

<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="exportModal">Choisir une option d'export</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="GET" action="{{ route('admin.believers.export_excel') }}" class="mb-3">
                    <div class="row">

                        {{-- Baptême --}}
                        <div class="form-group col-md-4">
                            <select name="baptized" class="form-control">
                                <option value="">-- Baptême --</option>
                                <option value="Oui">Baptisés</option>
                                <option value="Non">Non baptisés</option>
                            </select>
                        </div>

                        {{-- Discipline --}}
                        <div class="form-group col-md-4">
                            <select name="discipline" class="form-control">
                                <option value="">-- Discipline --</option>
                                <option value="oui">Sous discipline</option>
                                <option value="non">Pas sous discipline</option>
                            </select>
                        </div>

                        {{-- Catégorie d’âge --}}
                        <div class="form-group col-md-4">
                            <select name="category_id" class="form-control">
                                <option value="">-- Catégorie d’âge --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                        ({{ $category->min_age }} - {{ $category->max_age ?? '∞' }} ans)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                {{-- Export --}}
                <button class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> 
                    Exporter Excel
                </button>
            </div>
        </div>
    </div>
</div>
