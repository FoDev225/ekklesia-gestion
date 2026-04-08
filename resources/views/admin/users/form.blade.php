
@extends('layouts.app')

@section('title', $user->exists ? 'Modifier les infos de l\' utilisateur' : 'Ajouter un utilisateur')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    <form action="{{ $user->exists ? route('admin.users.update', $user->id) : route('admin.users.store') }}" 
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($user->exists)
            @method('PUT')
        @endif
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-primary text-primary text-uppercase">
                <strong>Informations de l'utilisateur</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {{-- USERNAME --}}
                        <div class="form-group mb-3">
                            <label for="believer_id" class="form-label" style="color: #000;">Choisir le fidèle <span class="text-danger">*</span></label>
                            <select name="believer_id" class="form-control @error('believer_id') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach($believers as $believer)
                                    <option value="{{ $believer->id }}" {{ old('believer_id') == $believer->id ? 'selected' : '' }}>
                                        {{ $believer->lastname }} {{ $believer->firstname }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="usernamePreview" class="text-danger"></small>
                            @error('believer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label" style="color: #000;">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" 
                                value="{{ old('password') }}">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-info">
            <div class="card-header bg-outline-info text-info text-uppercase">
                <strong>Rôles de l'utilisateur</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {{-- ROLES --}}
                        <div class="form-group mb-3">
                            <label for="roles" class="form-label" style="color: #000;">Rôles <span class="text-danger">*</span></label>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        class="form-check-input"
                                        {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        @error('roles')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- BOUTON D’ENVOI --}}
        <button type="submit" class="btn btn-primary mb-3">
            {{ $user->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        {{-- <a href="" class="btn btn-warning mb-3">Quitter la communauté</a> --}}
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">Annuler</a>
    </form>
      
</div>

<script>
    document.querySelector('select[name="believer_id"]').addEventListener('change', function () {
        const text = this.options[this.selectedIndex].text.toLowerCase();
        const parts = text.split(' ');
        if(parts.length >= 2){
            document.getElementById('usernamePreview').innerText =
                "Nom d'utilisateur : " + parts[1] + "." + parts[0];
        }
    });

</script>

@endsection
