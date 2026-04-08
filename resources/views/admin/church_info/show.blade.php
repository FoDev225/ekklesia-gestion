@extends('layouts.app')

@section('title', 'Fiche du fidèle : ' . $church_info->church_name)

@section('content')
    <div class="container-fluid py-4">
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
                    Informations de l'église du : 
                    <span class="badge bg-light text-primary">
                        {{ $church_info->church_name }}
                    </span>
            </div>

            <div class="card-body">

                {{-- 🧍 ÉTAT CIVIL --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        <i class="bi bi-person-lines-fill"></i> Informations Générales
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Organisation :</strong> {{ $church_info->organisation }}</p>
                        <p style="color: #000;"><strong>Description :</strong> {{ $church_info->organisation_name }}</p>
                        <p style="color: #000;"><strong>District :</strong> {{ $church_info->district }}</p>
                        <p style="color: #000;"><strong>Communauté locale :</strong> {{ $church_info->church_name }}</p>
                        <p style="color: #000;"><strong>Authorisation :</strong> {{ $church_info->authorization }}</p>
                    </div>
                </div>

                {{-- ✝️ INFORMATIONS RELIGIEUSES --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-droplet"></i> Contact & Adresse
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Adresse :</strong> {{ $church_info->address }}</p>
                        <p style="color: #000;"><strong>Contact Pasteur :</strong>{{ $church_info->pastor_phone_number}}</p>
                        <p style="color: #000;"><strong>Email Pasteur :</strong> {{ $church_info->pastor_email }}</p>
                        <p style="color: #000;"><strong>Contact Sécretariat :</strong> {{ $church_info->secretary_phone_number }}</p>
                        <p style="color: #000;"><strong>Email Sécretariat :</strong> {{ $church_info->church_email }}</p>
                        <p style="color: #000;"><strong>Localisation :</strong> {{ $church_info->localisation }}</p>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.church_info.edit', $church_info->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>

                <a href="{{ route('admin.church_info.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </div>

    </div>

@endsection