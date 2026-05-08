
@extends('layouts.app')

@section('title', $role->exists ? 'Modifier les infos du rôle' : 'Ajouter un rôle')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    <form action="{{ $role->exists ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" 
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($role->exists)
            @method('PUT')
        @endif
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-primary text-primary text-uppercase">
                <strong>Informations du rôle</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                         {{-- PASSWORD --}}
                        <div class="form-group mb-3">
                            <label for="name" class="form-label" style="color: #000;">Nom du rôle <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $role->name ?? '') }}" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                         {{-- CODE --}}
                        <div class="form-group mb-3">
                            <label for="code" class="form-label" style="color: #000;">Code du rôle <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror" 
                                value="{{ old('code', $role->code ?? '') }}" autofocus>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOUTON D’ENVOI --}}
        <button type="submit" class="btn btn-primary mb-3">
            {{ $role->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        {{-- <a href="" class="btn btn-warning mb-3">Quitter la communauté</a> --}}
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mb-3">Annuler</a>
    </form>
      
</div>

@endsection
