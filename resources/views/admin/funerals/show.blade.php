@extends('layouts.app')

@section('title', 'Fiche funéraire du parent du fidèle : ' . $funeral->believer?->firstname . ' ' . $funeral->believer?->lastname)

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

        <h2 class="mb-4 text-uppercase">Détails de la fiche</h2>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="bi bi-person-badge"></i>
                    Fiche funéraire
                </h4>
                
                <a href="{{ route('admin.funerals.pdf', $funeral->id) }}" 
                    class="btn btn-light text-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Imprimer la fiche PDF
                 </a>
            </div>
            <hr>

            <div class="card-body">
                {{-- ====================== FIDÈLE ENDEUILLÉ ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Fidèle endeuillé
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nom :</strong> {{ $funeral->believer?->firstname ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Prénom :</strong> {{ $funeral->believer?->lastname ?? '' }}</p>
                        <p style="color: #000;"><strong>Date de naissance :</strong> {{ $funeral->believer?->believer_birthdate ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Lieu de naissance :</strong> {{ $funeral->believer?->city_of_birth ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>État Matrimonial :</strong> {{ $funeral->believer?->marital_status ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Contact :</strong> {{ $funeral->believer?->contact ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- ====================== PARENT DÉCÉDÉ ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Parent décédé
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nom :</strong> {{ $funeral->parent_firstname }} {{ $funeral->parent_lastname }}</p>
                        <p style="color: #000;"><strong>Lien familial :</strong> {{ $funeral->family_relationship }}</p>
                        <p style="color: #000;"><strong>Cause du décès :</strong> {{ $funeral->cause_of_death }}</p>
                        <p style="color: #000;"><strong>Date du décès :</strong> {{ $funeral->death_date }}</p>
                        <p style="color: #000;"><strong>Lieu du décès :</strong> {{ $funeral->burial_place }}</p>
                    </div>
                </div>

                {{-- ====================== OBSÈQUES ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        Obsèques
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Date des obsèques :</strong> {{ $funeral->funeral_date }}</p>
                        <p style="color: #000;"><strong>Lieu des obsèques :</strong> {{ $funeral->funeral_place }}</p>
                    </div>
                </div>

                {{-- ====================== ASSISTANCE ÉGLISE ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        Assistance de l'église
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nombre de pagnes :</strong> {{ $funeral->loincloths_number }}</p>
                        <p style="color: #000;"><strong>Montant en numéraire :</strong> {{ number_format($funeral->amount_paid, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>

                {{-- ====================== ASSISTANCE FIDÈLES ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        Assistance des fidèles
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nombre de pagnes :</strong> {{ $funeral->nbre_pagne }}</p>
                        <p style="color: #000;"><strong>Montant en numéraire :</strong> {{ number_format($funeral->cash_amount, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>

                {{-- ====================== ASSISTANCE FIDÈLES ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        Total des assistances
                    </h5>
                    <div class="mt-2">
                        {{-- Total pagnes --}}
                        @php
                            $totalPagne = ($funeral->loincloths_number ?? 0) + ($funeral->nbre_pagne ?? 0);
                            $totalMontant = ($funeral->amount_paid ?? 0) + ($funeral->cash_amount ?? 0);
                        @endphp

                        <p style="color: #000;"><strong>Total des pagnes :</strong> {{ $totalPagne }}</p>
                        <p style="color: #000;">
                            <strong>Montant total :</strong>
                            {{ number_format($totalMontant, 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                </div>
            </div>

            {{-- ====================== BOUTON RETOUR ====================== --}}
            <div class="card-footer text-end">
                <a href="{{ route('admin.funerals.index') }}" class="btn btn-secondary mb-3">Retour à la liste</a>
                <a href="{{ route('admin.funerals.pdf', $funeral->id) }}" class="btn btn-info mb-3">
                    <i class="bi bi-file-earmark-pdf"></i> Imprimer la fiche PDF
                </a>
            </div>
        </div>
    </div>

@endsection