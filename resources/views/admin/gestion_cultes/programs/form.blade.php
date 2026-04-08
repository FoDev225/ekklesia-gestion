
@extends('admin.gestion_cultes.layouts.app')

@section('title', $program->exists ? 'Modifier le programme ' . $program->title : 'Créer un programme')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    {{-- ========== FORMULAIRE D'ENREGISTREMENT / MODIFICATION ========== --}}

    <form action="{{ $program->exists ? route('admin.programs.update', $program->id) : route('admin.programs.store') }}" 
        method="POST">
        @csrf
        @if($program->exists)
            @method('PUT')
        @endif
    
        {{-- ====================== PROGRAMME DU CULTE ====================== --}}
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-primary text-primary text-uppercase">
                <strong>Programme</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label" style="color: #000;">Titre <span class="text-danger">*</span></label>
                            <input type="text" name="programme[title]" id="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $program->title ?? '') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="description" class="form-label" style="color: #000;">Description</label>
                            <input type="text" name="programme[description]" id="description" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description', $program->description ?? '') }}">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
    
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label" style="color: #000;">Date début <span class="text-danger">*</span></label>
                            <input type="date" name="programme[start_date]" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date', $program->start_date ?? '') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="end_date" class="form-label" style="color: #000;">Date fin <span class="text-danger">*</span></label>
                            <input type="date" name="programme[end_date]" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', $program->end_date ?? '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input type="checkbox"
                                name="programme[is_actif]"
                                id="is_actif"
                                value="1"
                                class="form-check-input @error('programme.is_actif') is-invalid @enderror"
                                {{ old('programme.is_actif', $programme->is_actif ?? false) ? 'checked' : '' }}>

                            <label for="is_actif" class="form-check-label" style="color:#000;">
                                Activer le programme
                            </label>

                            @error('programme.is_actif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        {{-- ====================== THEME PRINCIPAL ====================== --}}
        <div class="card mb-4 shadow-sm border-info">
            <div class="card-header bg-outline-info text-info text-uppercase">
                <strong>Thème Principal</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="theme" class="form-label" style="color: #000;">Thème <span class="text-danger">*</span></label>
                            <input type="text" name="theme_principal[theme]" id="theme" class="form-control @error('theme') is-invalid @enderror"
                                    value="{{ old('theme', $program->theme ?? '') }}">
                            @error('theme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="text_biblique_principal" class="form-label" style="color: #000;">Texte(s) Biblique(s)</label>
                            <input type="text" name="theme_principal[text_biblique_principal]" id="text_biblique_principal" class="form-control @error('text_biblique_principal') is-invalid @enderror"
                                    value="{{ old('text_biblique_principal', $program->text_biblique_principal ?? '') }}">
                            @error('text_biblique_principal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        {{-- ====================== SOUS-THEME ====================== --}}
        <div class="card mb-4 shadow-sm border-success">
            <div class="card-header bg-outline-success text-success text-uppercase">
                <strong>Sous-Thèmes</strong>
            </div>
            <div class="card-body">
                <button type="button" id="addSousTheme" class="btn btn-sm btn-primary mb-3">
                    + Ajouter
                </button>
                <div class="row" id="sousThemesContainer">
                    <div class="col-md-5">
                        <div class="form-group mb-3">
                            <label for="sous_theme" class="form-label" style="color: #000;">Sous-Thème <span class="text-danger">*</span></label>
                            <input type="text" name="sous_themes[0][sous_theme]" id="sous_theme" class="form-control @error('sous_theme') is-invalid @enderror"
                                    value="{{ old('sous_theme', $program->sous_theme ?? '') }}">
                            @error('sous_theme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group mb-3">
                            <label for="text_biblique" class="form-label" style="color: #000;">Texte(s) Biblique(s)</label>
                            <input type="text" name="sous_themes[0][text_biblique]" id="text_biblique" class="form-control @error('text_biblique') is-invalid @enderror"
                                    value="{{ old('text_biblique', $program->text_biblique ?? '') }}">
                            @error('text_biblique')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger mt-4 removeSousTheme">
                            ✕
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
    
        {{-- ====================== BOUTONS ====================== --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                {{ $program->exists ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
  
      
</div>

<script>
    let index = 1;

    document.getElementById('addSousTheme').addEventListener('click', function () {
        const container = document.getElementById('sousThemesContainer');

        const html = `
            <div class="row sous-theme mb-2">
                <div class="col-md-5">
                    <div class="form-group mb-3">
                        <label for="sous_theme" 
                        class="form-label" style="color: #000;">
                        Sous-Thème <span class="text-danger">*</span></label>
                        <input type="text"
                            name="sous_themes[${index}][sous_theme]"
                            class="form-control"
                            placeholder="Sous-thème">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group mb-3">
                        <label for="text_biblique" 
                        class="form-label" style="color: #000;">
                        Texte(s) Biblique(s)</label>
                        <input type="text"
                            name="sous_themes[${index}][text_biblique]"
                            class="form-control"
                            placeholder="Texte biblique">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger mt-4 removeSousTheme">
                        ✕
                    </button>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        index++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeSousTheme')) {
            e.target.closest('.sous-theme').remove();
        }
    });
</script>


@endsection
