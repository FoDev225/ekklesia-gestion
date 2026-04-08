@extends('layouts.app')

@section('title', 'Fiche du fidèle : ' . $believer->lastname . ' ' . $believer->firstname)

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
                    Fiche du fidèle : 
                    <span class="badge bg-light text-primary">
                        {{ $believer->lastname }} {{ $believer->firstname }}
                    </span>
                </h4>
                <a href="{{ route('admin.believers.generate_pdf', $believer->id) }}" 
                    class="btn btn-light text-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
                 </a>
            </div>

            @if($believer->exists && $believer->disciplinarySituations()->where('status', 'active')->exists())
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <strong>{{ $believer->firstname }} {{ $believer->lastname }}</strong> est sous sanction disciplinaire. 
                        {{-- Veuillez cliquer sur le bouton <span class="bg-success p-1 text-white p-1 rounded">Lever la discipline</span> ci-dessous pour mettre fin à la sanction --}}
                    </div>
                </div>
            @endif

            <div class="card-body">

                {{-- 🧍 ÉTAT CIVIL --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        <i class="bi bi-person-lines-fill"></i> Informations personnelles
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Matricule :</strong> {{ $believer->register_number }}</p>
                        <p style="color: #000;"><strong>Genre :</strong> {{ $believer->gender }}</p>
                        <p style="color: #000;"><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($believer->birth_date)->format('d/m/Y') }}</p>
                        <p style="color: #000;"><strong>Ville de naissance :</strong> {{ $believer->birth_place }}</p>
                        <p style="color: #000;"><strong>Ethnie :</strong> {{ $believer->ethnicity }}</p>
                        <p style="color: #000;"><strong>Nationalité :</strong> {{ $believer->nationality ?? '--' }}</p>
                        <p style="color: #000;"><strong>Nombre d'enfants :</strong> {{ $believer->number_of_children }}</p>
                        <p style="color: #000;"><strong>N° CNI/PC/ATT/PASS/SEJOUR :</strong> {{ $believer->cni_number ?? '--' }}</p>
                        <p style="color: #000;"><strong>Catégorie Fidèle :</strong> {{ $believer->category->name ?? 'Non assignée' }}</p>
                        <p style="color: #000;"><strong>Family :</strong> {{ $believer->family->family_name ?? 'Non assignée' }}</p>
                    </div>
                </div>

                {{-- 🧍 ÉTAT CIVIL --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-3">
                        <i class="bi bi-heart-fill"></i> Situation matrimoniale
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Situation maritale :</strong> {{ $believer->marital_status }}</p>
                        <p style="color: #000;"><strong>Date du mariage :</strong> {{ \Carbon\Carbon::parse($believer->marriage_date)->format('d/m/Y') }}</p>
                        <p style="color: #000;"><strong>Nom du conjoint :</strong> {{ $believer->spouse_name }}</p>
                    </div>
                </div>

                {{-- 📞 CONTACT --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-telephone"></i> Adresse & Contact
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Contact WhatsApp :</strong> {{ $believer->address->whatsapp_number ?? '—' }}</p>
                        <p style="color: #000;"><strong>Autre contact :</strong> {{ $believer->address->phone_number ?? '—' }}</p>
                        <p style="color: #000;"><strong>Mail :</strong> {{ $believer->address->email ?? '—' }}</p>
                        <p style="color: #000;"><strong>Commune :</strong> {{ $believer->address->commune ?? '—' }}</p>
                        <p style="color: #000;"><strong>Quartier :</strong> {{ $believer->address->quartier ?? '—' }}</p>
                        <p style="color: #000;"><strong>Sous-quartier :</strong> {{ $believer->address->sous_quartier ?? '—' }}</p>
                    </div>
                </div>

                {{-- ✝️ INFORMATIONS RELIGIEUSES --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-droplet"></i> Baptême
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Connaissance à l'église :</strong> {{ $believer->churchInformation->connaissance_eglise ?? '—' }}</p>
                        <p style="color: #000;"><strong>Eglise d'origine :</strong> {{ $believer->churchInformation->original_church ?? '—' }}</p>
                        <p style="color: #000;"><strong>Année d’arrivée :</strong> {{ $believer->churchInformation->arrival_year ?? '—' }}</p>
                        <p style="color: #000;"><strong>Date de conversion :</strong> 
                            {{ $believer->churchInformation?->conversion_date?->format('d/m/Y') ?? 'Non renseignée' }}
                        </p>
                        <p style="color: #000;"><strong>Lieu de conversion :</strong> {{ $believer->churchInformation->conversion_place ?? '—' }}</p>
                        <p style="color: #000;"><strong>Baptisé(e) :</strong> {{ $believer->churchInformation?->baptised ?? '--' }}</p>
                        <p style="color: #000;"><strong>Date de baptême :</strong> 
                            {{ $believer->churchInformation?->baptism_date?->format('d/m/Y') ?? 'Non renseignée' }}
                        </p>
                        <p style="color: #000;"><strong>Lieu du baptême :</strong> {{ $believer->churchInformation->baptism_place ?? '—' }}</p>
                        <p style="color: #000;"><strong>Pasteur officiant :</strong> {{ $believer->churchInformation->baptism_pastor ?? '—' }}</p>
                        <p style="color: #000;"><strong>N° carte de baptême :</strong> {{ $believer->churchInformation->baptism_card_number ?? '—' }}</p>
                        <p style="color: #000;"><strong>N° carte de membre :</strong> {{ $believer->churchInformation->membership_card_number ?? '—' }}</p>
                    </div>
                </div>

                <div class="believer-section border-warning">
                <div class="text-uppercase text-dark border-bottom pb-2 mt-4">
                    <i class="bi bi-people"></i> Groupes
                </div>
                <div class="card-body">
                    @if($believer->groups->isEmpty())
                        <p class="text-muted mb-0">Aucun groupe renseigné.</p>
                    @else
                        <div class="row">
                            @foreach($believer->groups as $group)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 bg-light">
                                        <h6 class="fw-bold mb-2 text-primary">{{ $group->name }}</h6>

                                        <p class="mb-1">
                                            <strong>Rôle :</strong>
                                            <span class="badge bg-warning text-dark">
                                                {{ $group->pivot->role ?: 'Non défini' }}
                                            </span>
                                        </p>

                                        <p class="mb-0">
                                            <strong>Date d’intégration :</strong>
                                            {{ $group->pivot->joined_at ? \Carbon\Carbon::parse($group->pivot->joined_at)->format('d/m/Y') : 'Non renseignée' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

                {{-- 🎓 FORMATION & DIPLOME --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-mortarboard"></i> Formation & Diplôme
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Niveau d' études :</strong> {{ $believer->education->level_of_education ?? '—' }}</p>
                        <p style="color: #000;"><strong>Diplôme :</strong> {{ $believer->education->degree ?? '—' }}</p>
                        <p style="color: #000;"><strong>Qualification :</strong> {{ $believer->education->qualification ?? '—' }}</p>
                    </div>
                </div>

                {{-- 🎓 PROFESSION --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-mortarboard"></i> Profession
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Fonction :</strong> {{ $believer->profession->fonction ?? '—' }}</p>
                        <p style="color: #000;"><strong>Entrepise/Service :</strong> {{ $believer->profession->company ?? '—' }}</p>
                        <p style="color: #000;"><strong>Contact professionnel :</strong> {{ $believer->profession->professional_contact ?? '—' }}</p>
                    </div>
                </div>

                {{-- 🎓 Responsabilité --}}
                <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-mortarboard"></i> Responsabilité
                    </h5>
                    <div class="mt-2">
                        <p style="color: #000;"><strong>Antérieure :</strong> {{ $believer->responsibility->old ?? '—' }}</p>
                        <p style="color: #000;"><strong>Actuelle :</strong> {{ $believer->responsibility->current ?? '—' }}</p>
                        <p style="color: #000;"><strong>Souhaitée :</strong> {{ $believer->responsibility->desired ?? '—' }}</p>
                    </div>
                </div>

                 {{-- 🌐 LANGUES --}}
                 <div class="believer-section border-warning">
                    <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                        <i class="bi bi-translate"></i> Langues
                    </h5>
                    <div class="mt-2">
                        @if($believer->languages->isEmpty())
                            <p style="color: #000;">Aucune langue renseignée.</p>
                        @else
                            @foreach($believer->languages as $language)
                                <div class="mb-2 p-2 border rounded bg-light">
                                    <strong style="color: #000;">{{ $language->name }}</strong>

                                    <div class="mt-1">
                                        <span class="me-2" style="color: #000;">Lu :</span>
                                        <span class="badge {{ $language->pivot->spoken ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $language->pivot->spoken ? 'Oui' : 'Non' }}
                                        </span>

                                        <span class="ms-3 me-2" style="color: #000;">Écrit :</span>
                                        <span class="badge {{ $language->pivot->written ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $language->pivot->written ? 'Oui' : 'Non' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                @if($believer->disciplinarySituations->where('status', 'active')->isNotEmpty())
                    @php
                        $discipline = $believer->disciplinarySituations->where('status', 'active')->first();
                    @endphp

                    <div class="believer-section border-danger">
                        <h5 class="text-uppercase text-dark border-bottom pb-2 mt-4">
                            <i class="bi bi-exclamation-octagon"></i> Discipline en cours
                        </h5>
                        <div class="mt-2">
                            <p style="color: #000;"><strong>Motif :</strong> {{ $discipline->reason }}</p>
                            <p style="color: #000;"><strong>Date début :</strong> {{ \Carbon\Carbon::parse($discipline->start_date)->format('d/m/Y') }}</p>
                            <p style="color: #000;"><strong>Date fin prévue :</strong> {{ $discipline->end_date ? \Carbon\Carbon::parse($discipline->end_date)->format('d/m/Y') : 'Décision du conseil' }}</p>
                            <p style="color: #000;"><strong>Observation :</strong> {{ $discipline->observations }}</p>
                        </div>
                    </div>
                @endif


            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.believers.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
                <a href="{{ route('admin.believers.generate_pdf', $believer->id) }}" 
                    class="btn btn-info">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
                 </a>
                <a href="{{ route('admin.believers.edit', $believer->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Modifier
                </a>
            </div>
        </div>

    </div>

@endsection