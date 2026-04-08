
@extends('layouts.app')

@section('title', $child_dedication->exists ? 'Modifier la fiche de l\'enfant ' . $child_dedication->child_firstname . ' ' . $child_dedication->child_lastname : 'Ajouter une fiche de présentation d\'enfant')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    {{-- ========== FORMULAIRE D'ENREGISTREMENT / MODIFICATION ========== --}}

    <form action="{{ $child_dedication->exists ? route('admin.child_dedications.update', $child_dedication->id) : route('admin.child_dedications.store') }}" 
        method="POST">
        @csrf
        @if($child_dedication->exists)
            @method('PUT')
        @endif

        {{-- ====================== PARENTS DE L'ENFANT ====================== --}}
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-primary text-primary text-uppercase">
                <strong>Parents</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="father_id" class="form-label" style="color: #000;">Père <span class="text-danger">*</span></label>
                            <select name="father_id" id="father_id" class="form-control @error('father_id') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach(\App\Models\Believer::where('gender', 'Masculin')->where('marital_status', 'Marié(e)')->get() as $c)
                                    <option value="{{ $c->id }}" 
                                        {{ (old('father_id') ?? $child_dedication->father_id ?? '') == $c->id ? 'selected' : '' }}>
                                        {{ $c->lastname }} {{ $c->firstname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('father_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="mother_id" class="form-label" style="color: #000;">Mère <span class="text-danger">*</span></label>
                            <select name="mother_id" id="mother_id" class="form-control @error('mother_id') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach(\App\Models\Believer::where('gender', 'Féminin')->where('marital_status', 'Marié(e)')->get() as $c)
                                    <option value="{{ $c->id }}" 
                                        {{ (old('mother_id') ?? $child_dedication->mother_id ?? '') == $c->id ? 'selected' : '' }}>
                                        {{ $c->lastname }} {{ $c->firstname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mother_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- ====================== DATES ====================== --}}
        <div class="card mb-4 shadow-sm border-secondary">
            <div class="card-header bg-outline-secondary text-secondary text-uppercase">
                <strong>Date</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="demande_date" class="form-label" style="color: #000;">Date de la demande <span class="text-danger">*</span></label>
                            <input type="date" name="demande_date" id="demande_date" class="form-control @error('demande_date') is-invalid @enderror"
                                    value="{{ old('demande_date', optional($child_dedication->demande_date)->format('Y-m-d')) }}">
                            @error('demande_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="dedication_date" class="form-label" style="color: #000;">Date présentation <span class="text-danger">*</span></label>
                            <input type="date" name="dedication_date" id="dedication_date" class="form-control @error('dedication_date') is-invalid @enderror"
                                    value="{{ old('dedication_date', optional($child_dedication->dedication_date)->format('Y-m-d')) }}">
                            @error('dedication_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- ====================== ENFANT ====================== --}}
        <div class="card mb-4 shadow-sm border-success">
            <div class="card-header bg-outline-success text-success text-uppercase">
                <strong>L'enfant</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="child_lastname" class="form-label" style="color: #000;">Nom<span class="text-danger">*</span></label>
                            <input type="text" name="child_lastname" id="child_lastname" class="form-control"
                                    value="{{ old('child_lastname', $child_dedication->child_lastname ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="child_firstname" class="form-label" style="color: #000;">Prénoms <span class="text-danger">*</span></label>
                            <input type="text" name="child_firstname" id="child_firstname" class="form-control @error('child_firstname') is-invalid @enderror"
                                    value="{{ old('child_firstname', $child_dedication->child_firstname ?? '') }}">
                            @error('child_firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="gender" class="form-label" style="color: #000;">Genre <span class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach(App\Models\ChildDedication::child_gender() as $g)
                                    <option value="{{ $g }}" {{ old('gender', $child_dedication->gender ?? '') == $g ? 'selected' : '' }}>
                                        {{ $g }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="child_birthdate" class="form-label" style="color: #000;">Date de naissance <span class="text-danger">*</span></label>
                            <input type="date" name="child_birthdate" id="child_birthdate" class="form-control @error('child_birthdate') is-invalid @enderror"
                                    value="{{ old('child_birthdate', optional($child_dedication->child_birthdate)->format('Y-m-d')) }}">
                            @error('child_birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="child_birthplace" class="form-label" style="color: #000;">Lieu de naissance <span class="text-danger">*</span></label>
                            <input type="text" name="child_birthplace" id="child_birthplace" class="form-control @error('child_birthplace') is-invalid @enderror"
                                    value="{{ old('child_birthplace', $child_dedication->child_birthplace ?? '') }}">
                            @error('child_birthplace')
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
                {{ $child_dedication->exists ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
            <a href="{{ route('admin.child_dedications.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
  
      
</div>

@endsection
