
@extends('layouts.app')

@section('title', $funeral->exists ? 'Modifier la fiche de ' . $funeral->believer->firstname . ' ' . $funeral->believer->lastname : 'Ajouter une fiche funéraire')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    {{-- ========== FORMULAIRE D'ENREGISTREMENT / MODIFICATION ========== --}}

    <form action="{{ $funeral->exists ? route('admin.funerals.update', $funeral->id) : route('admin.funerals.store') }}" 
        method="POST">
        @csrf
        @if($funeral->exists)
            @method('PUT')
        @endif
    
        {{-- ====================== FIDÈLE ENDEUILLÉ ====================== --}}
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-primary text-primary text-uppercase">
                <strong>Fidèle endeuillé</strong>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="believer_id" class="form-label" style="color: #000;">Nom <span class="text-danger">*</span></label>
                    <select name="believer_id" id="believer_id" class="form-control @error('believer_id') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach(\App\Models\Believer::all() as $c)
                            <option value="{{ $c->id }}" 
                                {{ (old('believer_id') ?? $funeral->believer_id ?? '') == $c->id ? 'selected' : '' }}>
                                {{ $c->firstname }} {{ $c->lastname }}
                            </option>
                        @endforeach
                    </select>
                    @error('believer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    
        {{-- ====================== PARENT DÉCÉDÉ ====================== --}}
        <div class="card mb-4 shadow-sm border-danger">
            <div class="card-header bg-outline-danger text-danger text-uppercase">
                <strong>Parent décédé</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="parent_firstname" class="form-label" style="color: #000;">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="parent_firstname" id="parent_firstname" class="form-control @error('parent_firstname') is-invalid @enderror"
                                    value="{{ old('parent_firstname', $funeral->parent_firstname ?? '') }}">
                            @error('parent_firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="parent_lastname" class="form-label" style="color: #000;">Prénom(s) <span class="text-danger">*</span></label>
                            <input type="text" name="parent_lastname" id="parent_lastname" class="form-control @error('parent_lastname') is-invalid @enderror"
                                    value="{{ old('parent_lastname', $funeral->parent_lastname ?? '') }}">
                            @error('parent_lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="family_relationship" class="form-label" style="color: #000;">Lien familial <span class="text-danger">*</span></label>
                            <input type="text" name="family_relationship" id="family_relationship" class="form-control @error('family_relationship') is-invalid @enderror"
                                    value="{{ old('family_relationship', $funeral->family_relationship ?? '') }}">
                            @error('family_relationship')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cause_of_death" class="form-label" style="color: #000;">Cause du décès</label>
                            <input type="text" name="cause_of_death" id="cause_of_death" class="form-control @error('cause_of_death') is-invalid @enderror"
                                    value="{{ old('cause_of_death', $funeral->cause_of_death ?? '') }}">
                            @error('cause_of_death')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="death_date" class="form-label" style="color: #000;">Date du décès <span class="text-danger">*</span></label>
                            <input type="date" name="death_date" id="death_date" class="form-control"
                                    value="{{ old('death_date', $funeral->death_date ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="burial_place" class="form-label" style="color: #000;">Lieu du décès <span class="text-danger">*</span></label>
                            <input type="text" name="burial_place" id="burial_place" class="form-control @error('burial_place') is-invalid @enderror"
                                    value="{{ old('burial_place', $funeral->burial_place ?? '') }}">
                            @error('burial_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- ====================== OBSÈQUES ====================== --}}
        <div class="card mb-4 shadow-sm border-warning">
            <div class="card-header bg-outline-warning text-warning text-uppercase">
                <strong>Obsèques</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="funeral_date" class="form-label" style="color: #000;">Date des obsèques <span class="text-danger">*</span></label>
                            <input type="date" name="funeral_date" id="funeral_date" class="form-control"
                                    value="{{ old('funeral_date', $funeral->funeral_date ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="funeral_place" class="form-label" style="color: #000;">Lieu des obsèques <span class="text-danger">*</span></label>
                            <input type="text" name="funeral_place" id="funeral_place" class="form-control @error('funeral_place') is-invalid @enderror"
                                    value="{{ old('funeral_place', $funeral->funeral_place ?? '') }}">
                            @error('funeral_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- ====================== ASSISTANCE ÉGLISE ====================== --}}
        <div class="card mb-4 shadow-sm border-info">
            <div class="card-header bg-outline-info text-info ext-uppercase">
                <strong>Assistance de l'église</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="loincloths_number" class="form-label" style="color: #000;">Nombre de pagne <span class="text-danger">*</span></label>
                            <input type="number" name="loincloths_number" id="loincloths_number" class="form-control @error('loincloths_number') is-invalid @enderror"
                                    value="{{ old('loincloths_number', $funeral->loincloths_number ?? '') }}">
                            @error('loincloths_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="amount_paid" class="form-label" style="color: #000;">Montant en numéraire <span class="text-danger">*</span></label>
                            <input type="number" name="amount_paid" id="amount_paid" class="form-control @error('amount_paid') is-invalid @enderror"
                                    value="{{ old('amount_paid', $funeral->amount_paid ?? '') }}">
                            @error('amount_paid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- ====================== ASSISTANCE FIDÈLES ====================== --}}
        <div class="card mb-4 shadow-sm border-success">
            <div class="card-header bg-outline-success text-success text-uppercase">
                <strong>Assistance des fidèles</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nbre_pagne" class="form-label" style="color: #000;">Nombre de pagne <span class="text-danger">*</span></label>
                            <input type="number" name="nbre_pagne" id="nbre_pagne" class="form-control @error('nbre_pagne') is-invalid @enderror"
                                    value="{{ old('nbre_pagne', $funeral->nbre_pagne ?? '') }}">
                            @error('nbre_pagne')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cash_amount" class="form-label" style="color: #000;">Montant en numéraire <span class="text-danger">*</span></label>
                            <input type="number" name="cash_amount" id="cash_amount" class="form-control @error('cash_amount') is-invalid @enderror"
                                    value="{{ old('cash_amount', $funeral->cash_amount ?? '') }}">
                            @error('cash_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- ====================== BOUTONS ====================== --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">
                {{ $funeral->exists ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
            <a href="{{ route('admin.funerals.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
  
      
</div>

@endsection
