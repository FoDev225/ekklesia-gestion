@extends('layouts.app')

@section('title', 'Fiche de présentation de l\'enfant : ' .  $child_dedication->child_lastname . ' ' . $child_dedication->child_firstname)

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

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="bi bi-person-badge"></i>
                    Fiche de présentation de l'enfant : 
                    <span class="badge bg-light text-primary">
                        {{ $child_dedication->child_lastname }} {{ $child_dedication->child_firstname }}
                    </span>
                </h4>
                
                <a href="{{ route('admin.child_dedications.generate_pdf', $child_dedication->id) }}" 
                    class="btn btn-light text-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
                 </a>
            </div>

            <div class="card-body">
                {{-- ====================== PERE ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Père de l'enfant
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nom :</strong> {{ $child_dedication->father?->firstname ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Prénom :</strong> {{ $child_dedication->father?->lastname ?? '' }}</p>
                        <p style="color: #000;"><strong>Date de naissance :</strong> {{ optional($child_dedication->father?->believer_birthdate)->format('d/m/Y') ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Lieu de naissance :</strong> {{ $child_dedication->father?->city_of_birth ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>État Matrimonial :</strong> {{ $child_dedication->father?->marital_status ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Contact :</strong> {{ $child_dedication->father?->contact ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- ====================== MERE ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3"> 
                        Mère de l'enfant
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nom :</strong> {{ $child_dedication->mother?->firstname ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Prénom :</strong> {{ $child_dedication->mother?->lastname ?? '' }}</p>
                        <p style="color: #000;"><strong>Date de naissance :</strong> {{ optional($child_dedication->mother?->believer_birthdate)->format('d/m/Y') ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Lieu de naissance :</strong> {{ $child_dedication->mother?->city_of_birth ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>État Matrimonial :</strong> {{ $child_dedication->mother?->marital_status ?? 'N/A' }}</p>
                        <p style="color: #000;"><strong>Contact :</strong> {{ $child_dedication->mother?->contact ?? 'N/A' }}</p>
                    </div>
                    </div>

                {{-- ====================== DATE ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        Date
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Date de demande :</strong> {{ optional($child_dedication->demande_date)->format('d/m/Y') }}</p>
                        <p style="color: #000;"><strong>Date de présentation :</strong> {{ optional($child_dedication->dedication_date)->format('d/m/Y') }}</p>
                    </div>
                </div>

                {{-- ====================== L'ENFANT ====================== --}}
                <div class="believer-section">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        L'enfant
                    </h5>
                    <div class="mt-2">
                       <p style="color: #000;"><strong>Nom & Prénoms :</strong> {{ $child_dedication->child_lastname }}</p>
                       <p style="color: #000;"><strong>Prénoms :</strong> {{ $child_dedication->child_firstname }}</p>
                        <p style="color: #000;"><strong>Genre :</strong> {{ $child_dedication->gender }}</p>
                        <p style="color: #000;"><strong>Lieu de naissance :</strong> {{ $child_dedication->child_birthplace }}</p>
                        <p style="color: #000;"><strong>Date de naissance :</strong> {{ optional($child_dedication->child_birthdate)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.child_dedications.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>

                <a href="{{ route('admin.child_dedications.generate_pdf', $child_dedication->id) }}" 
                    class="btn btn-info">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
                </a>

                <a href="{{ route('admin.child_dedications.edit', $child_dedication->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>
            </div>
        </div>

    </div>

@endsection