@extends('layouts.app')

@section('title', 'Fiche de mariage de : ' . $mariage->groom->lastname . ' ' . $mariage->bride->lastname)

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
                    Fiche de mariage de : 
                    <span class="badge bg-light text-primary">
                        {{ $mariage->groom->lastname }} {{ $mariage->bride->lastname }}
                    </span>
                </h4>
                <a href="{{ route('admin.mariages.generate_pdf', $mariage->id) }}" 
                    class="btn btn-light text-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
                 </a>
            </div>

            <div class="card-body">

                {{-- 🧍 LE MARIE --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        <i class="bi bi-person-lines-fill"></i> Le Marié
                    </h5>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="col-md-9">
                                <p style="color: #000;"><strong>Nom & Prénoms :</strong> {{ $mariage->groom->lastname }} {{ $mariage->groom->firstname }}</p>
                                <p style="color: #000;"><strong>Date & Lieu de naissance :</strong> {{ \Carbon\Carbon::parse($mariage->groom->birth_date)->format('d/m/Y') }} <strong>à</strong> {{ $mariage->groom->city_of_birth }}</p>
                                <p style="color: #000;"><strong>Baptisé le :</strong> {{ \Carbon\Carbon::parse($mariage->groom->baptism_date)->format('d/m/Y') }} <strong>à</strong> {{ $mariage->groom->baptism_place }}</p>
                                <p style="color: #000;"><strong>Par :</strong> {{ $mariage->groom->baptism_by }}</p>
                                <p style="color: #000;"><strong>Profession :</strong> {{ $mariage->groom->profession }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            @if($mariage->groom_photo)
                                <img src="{{ asset('storage/' . $mariage->groom_photo) }}" alt="Photo de {{ $mariage->groom->lastname }}" class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Photo par défaut" class="img-fluid rounded" style="max-height: 200px;">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 🧍 LA MARIEE --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        <i class="bi bi-person-lines-fill"></i> La Mariée
                    </h5>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mt-2">
                                <p style="color: #000;"><strong>Nom & Prénoms :</strong> {{ $mariage->bride->lastname }} {{ $mariage->bride->firstname }}</p>
                                <p style="color: #000;"><strong>Date & Lieu de naissance :</strong> {{ \Carbon\Carbon::parse($mariage->bride->birth_date)->format('d/m/Y') }} <strong>à</strong> {{ $mariage->bride->city_of_birth }}</p>
                                <p style="color: #000;"><strong>Baptisé le :</strong> {{ \Carbon\Carbon::parse($mariage->bride->baptism_date)->format('d/m/Y') }} <strong>à</strong> {{ $mariage->bride->baptism_place }}</p>
                                <p style="color: #000;"><strong>Par :</strong> {{ $mariage->bride->baptism_by }}</p>
                                <p style="color: #000;"><strong>Profession :</strong> {{ $mariage->bride->profession }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            @if($mariage->bride_photo)
                                <img src="{{ asset('storage/' . $mariage->bride_photo) }}" alt="Photo de {{ $mariage->bride->lastname }}" class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" alt="Photo par défaut" class="img-fluid rounded" style="max-height: 200px;">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ✝️ MARIAGE CIVIL --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-heart"></i> Mariage Civil
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Date :</strong> {{ \Carbon\Carbon::parse($mariage->civil_marriage_date)->format('d/m/Y') }}</p>
                        <p style="color: #000;"><strong>Lieu :</strong> {{ $mariage->civil_marriage_place }}</p>
                    </div>
                </div>

                {{-- 📞 MARIAGE RELIGIEUX --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-house-heart"></i> Mariage Religieux
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Date :</strong> {{ \Carbon\Carbon::parse($mariage->religious_marriage_date)->format('d/m/Y') }}</p>
                        <p style="color: #000;"><strong>Lieu :</strong> {{ $mariage->religious_marriage_place }}</p>
                        <p style="color: #000;"><strong>Maître de cérémonie :</strong> {{ $mariage->wedding_mc }}</p>
                        <p style="color: #000;"><strong>Prédicateur :</strong> {{ $mariage->wedding_preacher }}</p>
                        <p style="color: #000;"><strong>Remise de la Bible :</strong> {{ $mariage->hand_bible }}</p>
                        <p style="color: #000;"><strong>Pasteur officiant :</strong> {{ $mariage->officiant }}
                    </div>
                </div>

                {{-- 🎓 TEMOIN MARIE --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-mortarboard"></i> Temoin du Marié
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nom & Prénoms :</strong> {{ $mariage->groom_witness }}</p>
                        <p style="color: #000;"><strong>Profession :</strong> {{ $mariage->groom_witness_profession }}</p>
                    </div>
                </div>

                {{-- 🎓 TEMOIN MARIEE --}}
                <div class="believer-section border-secondary">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-mortarboard"></i> Temoin de la Mariée
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Nom & Prénoms :</strong> {{ $mariage->bride_witness }}</p>
                        <p style="color: #000;"><strong>Profession :</strong> {{ $mariage->bride_witness_profession }}</p>
                    </div>
                </div>


            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.mariages.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
                <a href="{{ route('admin.mariages.generate_pdf', $mariage->id) }}" 
                    class="btn btn-info">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
                 </a>
                <a href="{{ route('admin.mariages.edit', $mariage->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>
            </div>
        </div>

    </div>

@endsection