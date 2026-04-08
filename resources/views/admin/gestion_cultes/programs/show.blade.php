@extends('admin.gestion_cultes.layouts.app')

@section('title', 'Programme : ' . $program->title)

@section('content')

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="mb-4 text-uppercase">Détails du programme</h2>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="bi bi-person-badge"></i>
                    Programme du {{ $program->title }}
                </h4>
                
                <a href="" 
                    class="btn btn-light text-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Imprimer la fiche PDF
                 </a>
            </div>
            <hr>

            <div class="card-body">
                {{-- ====================== PROGRAMME ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Programme
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Titre :</strong> {{ $funeral->title ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Date début :</strong> {{ $funeral->start_date ?? '' }}</p>
                        <p style="color: #000;"><strong>Date fin :</strong> {{ $funeral->end_date ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Description :</strong> {{ $funeral->description ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Actif :</strong> {{ $funeral->is_active ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- ====================== THEME PRINCIPAL ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Thème Principal
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Thème :</strong> {{ $program->themePrincipal->theme }}</p>
                        <p style="color: #000;"><strong>Texte(s) Biblique(s) :</strong> {{ $program->themePrincipal->text_biblique_principal }}</p>
                    </div>
                </div>

                {{-- ====================== SOUS THEME ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Sous Thème
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Sous thème :</strong> </p>
                        <p style="color: #000;"><strong>Texte(s) Biblique(s) :</strong> </p>
                    </div>
                </div>

            {{-- ====================== BOUTON RETOUR ====================== --}}
            <div class="card-footer text-end">
                <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary mb-3">Retour à la liste</a>
                <a href="" class="btn btn-info mb-3">
                    <i class="bi bi-file-earmark-pdf"></i> Imprimer la programme
                </a>
            </div>
        </div>
    </div>

@endsection