
@extends('layouts.app')

@section('title', $believer->exists ? 'Modifier la fiche de ' . $believer->lastname . ' ' . $believer->firstname : 'Ajouter un fidèle')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- @if($believer->exists && $believer->disciplinarySituations()->where('status', 'active')->exists())
        <div class="alert alert-danger d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>
                <strong>{{ $believer->firstname }} {{ $believer->lastname }}</strong> est sous sanction disciplinaire
            </div>
        </div>
    @endif --}}

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    <form action="{{ $believer->exists ? route('admin.believers.update', $believer->id) : route('admin.believers.store') }}" 
        method="POST">
        @csrf
        @if($believer->exists)
            @method('PUT')
        @endif
        
        @include('admin.believers.form_partials.general_info')

        @include('admin.believers.form_partials.marital_status')

        @include('admin.believers.form_partials.adresses')

        @include('admin.believers.form_partials.church_infos')

        @include('admin.believers.form_partials.education')

        @include('admin.believers.form_partials.professions')

        @include('admin.believers.form_partials.responsibility')

        @include('admin.believers.form_partials.languages')

        @include('admin.believers.form_partials.group')


        {{-- BOUTON D’ENVOI --}}
        <button type="submit" class="btn btn-success mb-3">
            {{ $believer->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>

        @if($believer->exists)
            @if($believer->exists && $believer->disciplinarySituations()->where('status', 'active')->exists())
                <button type="button" class="btn btn-success d-inline-block mb-3" data-bs-toggle="modal" data-bs-target="#releaseDisciplineModal"
                data-toggle="tooltip" data-placement="bottom" title="Lever la sanction disciplinaire">
                    <i class="bi bi-check-circle"></i> Lever la sanction
                </button>
            @else 
                <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#disciplineModal" 
                data-toggle="tooltip" data-placement="bottom" title="Mettre sous sanction disciplinaire">
                    Mettre sous discipline
                </button>
            @endif

            <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#quitterModal" 
            data-toggle="tooltip" data-placement="bottom" title="Quitter la communauté">
                Quitter la communauté
            </button>
        @endif
        {{-- <a href="" class="btn btn-warning mb-3">Quitter la communauté</a> --}}
        <a href="{{ route('admin.believers.index') }}" class="btn btn-warning mb-3">Annuler</a>
    </form>
    
    @if($believer->exists)
        @include('admin.believers.modal.sanction-modal')
        @include('admin.believers.modal.departure-modal')
    @endif
      
</div>

@endsection
