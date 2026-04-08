
@extends('layouts.app')

@section('title', $church_info->exists ? 'Modifier les infos de l\' ' . $church_info->church_name : 'Ajouter des infos')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    <form action="{{ $church_info->exists ? route('admin.church_info.update', $church_info->id) : route('admin.church_info.store') }}" 
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($church_info->exists)
            @method('PUT')
        @endif
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-danger text-primary text-uppercase">
                <strong>Informations Générales</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        {{-- ORGANISATION --}}
                        <div class="form-group mb-3">
                            <label for="organisation" class="form-label" style="color: #000;">Organisation <span class="text-danger">*</span></label>
                            <input type="text" name="organisation" id="organisation" class="form-control @error('organisation') is-invalid @enderror"
                                    value="{{ old('organisation', $church_info->organisation ?? '') }}">
                            @error('organisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-9">
                        {{-- ORGANISATION NAME --}}
                        <div class="form-group mb-3">
                            <label for="organisation_name" class="form-label" style="color: #000;">Description <span class="text-danger">*</span></label>
                            <input type="text" name="organisation_name" id="organisation_name" class="form-control @error('organisation_name') is-invalid @enderror"
                                    value="{{ old('organisation_name', $church_info->organisation_name ?? '') }}">
                            @error('organisation_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        {{-- DISTRICT --}}
                        <div class="form-group mb-3">
                            <label for="district" class="form-label" style="color: #000;">District <span class="text-danger">*</span></label>
                            <input type="text" name="district" id="district" class="form-control @error('district') is-invalid @enderror"
                                value="{{ old('district', $church_info->district ?? '') }}">
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        {{-- CHURCH NAME --}}
                        <div class="form-group mb-3">
                            <label for="church_name" class="form-label" style="color: #000;">Communauté <span class="text-danger">*</span></label>
                            <input type="text" name="church_name" id="church_name" class="form-control @error('church_name') is-invalid @enderror"
                                    value="{{ old('church_name', $church_info->church_name ?? '') }}">
                            @error('church_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Nombre d'enfants --}}
                        <div class="form-group mb-3">
                            <label for="authorization" class="form-label" style="color: #000;">Authorisation</label> <span class="text-danger">*</span></label>
                            <input type="text" name="authorization" id="authorization" class="form-control @error('authorization') is-invalid @enderror"
                                    value="{{ old('authorization', $church_info->authorization ?? '') }}">
                            @error('authorization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-danger text-primary text-uppercase">
                <strong>Contact & Adresse</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        {{-- ADDRESS --}}
                        <div class="form-group mb-3">
                            <label for="address" class="form-label" style="color: #000;">Adresse</label> <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('birth_date', $church_info->address ?? '') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- PASTOR PHONE --}}
                        <div class="form-group mb-3">
                            <label for="pastor_phone_number" class="form-label" style="color: #000;">Contact Pasteur</label> <span class="text-danger">*</span></label>
                            <input type="text" name="pastor_phone_number" id="pastor_phone_number" class="form-control @error('pastor_phone_number') is-invalid @enderror"
                                    value="{{ old('pastor_phone_number', $church_info->pastor_phone_number ?? '') }}">
                            @error('pastor_phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- SECRETARY PHONE --}}
                        <div class="form-group mb-3">
                            <label for="secretary_phone_number" class="form-label" style="color: #000;">Contact Sécretariat</label> <span class="text-danger">*</span></label>
                            <input type="text" name="secretary_phone_number" id="secretary_phone_number" class="form-control @error('secretary_phone_number') is-invalid @enderror"
                                    value="{{ old('secretary_phone_number', $church_info->secretary_phone_number ?? '') }}">
                            @error('secretary_phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {{-- PASTOR EMAIL --}}
                        <div class="form-group mb-3">
                            <label for="pastor_email" class="form-label" style="color: #000;">Email Pasteur</label> <span class="text-danger">*</span></label>
                            <input type="text" name="pastor_email" id="pastor_email" class="form-control @error('pastor_email') is-invalid @enderror"
                                    value="{{ old('pastor_email', $church_info->pastor_email ?? '') }}">
                            @error('pastor_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{-- SECRETARY EMAIL --}}
                        <div class="form-group mb-3">
                            <label for="church_email" class="form-label" style="color: #000;">Email Sécretariat</label> <span class="text-danger">*</span></label>
                            <input type="text" name="church_email" id="church_email" class="form-control @error('church_email') is-invalid @enderror"
                                    value="{{ old('church_email', $church_info->church_email ?? '') }}">
                            @error('church_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        {{-- LOCALISATION --}}
                        <div class="form-group mb-3">
                            <label for="localisation" class="form-label" style="color: #000;">Localisation <span class="text-danger">*</span></label>
                            <input type="text" name="localisation" id="localisation" class="form-control @error('localisation') is-invalid @enderror"
                                    value="{{ old('localisation', $church_info->localisation ?? '') }}">
                            @error('localisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror  
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- LOGO --}}
                        <div class="form-group mb-3">
                            <label for="photo_path" class="form-label" style="color: #000;">Logo</label>
                            <input type="file" name="photo_path" id="photo_path" class="form-control @error('photo_path') is-invalid @enderror"
                                accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                            @error('photo_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Aperçu de la nouvelle image --}}
                        <img id="preview" style="max-width: 200px; display: none; border:1px solid #ddd; padding:5px; border-radius:5px;"/>

                        @if(isset($church_info->photo_path))
                            {{-- Image actuelle --}}
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $church_info->photo_path) }}" 
                                    alt="Logo actuel" 
                                    style="max-width: 120px; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                            </div>
                        @endif

                        {{-- Script pour l’aperçu --}}
                        <script>
                            function previewImage(event) {
                                var preview = document.getElementById('preview');
                                preview.src = URL.createObjectURL(event.target.files[0]);
                                preview.style.display = "block";
                            }
                        </script>

                        
                    </div>
                </div>
            </div> 
        </div>

        {{-- BOUTON D’ENVOI --}}
        <button type="submit" class="btn btn-primary mb-3">
            {{ $church_info->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        {{-- <a href="" class="btn btn-warning mb-3">Quitter la communauté</a> --}}
        <a href="{{ route('admin.church_info.index') }}" class="btn btn-secondary mb-3">Annuler</a>
    </form>
      
</div>

@endsection
