@extends('layouts.app')

@section('title', 'Programme de cultes')

@section('content')

    <div class="container-fluid">

        {{-- ERREURS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erreur :</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf

            {{-- ===================== PERIODE ===================== --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header">
                    <strong>Période</strong>
                </div>

                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label>Période</label>
                        <input type="text" name="periode[name]" class="form-control"
                            value="{{ old('periode.name') }}"
                            placeholder="Juin - Septembre 2026">
                    </div>

                    <div class="col-md-4">
                        <label>Date début</label>
                        <input type="date" name="periode[start_date]" class="form-control"
                            value="{{ old('periode.start_date') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Date fin</label>
                        <input type="date" name="periode[end_date]" class="form-control"
                            value="{{ old('periode.end_date') }}">
                    </div>

                    <div class="col-md-8">
                        <label>Thème général</label>
                        <input type="text" name="periode[general_theme]" class="form-control"
                            value="{{ old('periode.general_theme') }}">
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label for="activeSwitch">Activer le programme :</label>
                        <div class="form-check form-switch ml-5">
                            <input class="form-check-input" type="checkbox" name="periode[is_active]" id="activeSwitch"
                                {{ old('periode.is_active') ? 'checked' : '' }}>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===================== SERVICES ===================== --}}
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between">
                    <strong>Programmation des cultes</strong>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addService()">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>

                <div class="card-body" id="services-container">
                    {{-- Les cultes seront injectés ici --}}
                </div>
            </div>

            {{-- TEMPLATE --}}
            <script type="text/template" id="service-template">
                <div class="border rounded p-3 mb-4 service-block">

                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-bold text-primary">Culte #{index}</h6>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeService(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" name="services[{index}][date]" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Thème</label>
                            <input type="text" name="services[{index}][theme]" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Type du culte</label>
                            <input type="text" name="services[{index}][type]" class="form-control">
                        </div>
                    </div>

                    <hr>

                    {{-- PRÉDICATEUR --}}
                    <div class="row mb-2">
                        <div class="col-md-3">Prédicateur (Titulaire)</div>
                        <div class="col-md-4">
                            <select name="services[{index}][preacher_main]" class="form-select">
                                <option value="">-- Choisir --</option>
                                @foreach($believers as $b)
                                    <option value="{{ $b->id }}">{{ $b->firstname }} {{ $b->lastname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">Suppléant</div>
                        <div class="col-md-2">
                            <select name="services[{index}][preacher_backup]" class="form-select">
                                <option value="">--</option>
                                @foreach($believers as $b)
                                    <option value="{{ $b->id }}">{{ $b->firstname }} {{ $b->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- PRÉSIDENCE --}}
                    <div class="row mb-2">
                        <div class="col-md-3">Présidence</div>
                        <div class="col-md-4">
                            <select name="services[{index}][president_main]" class="form-select">
                                <option value="">-- Choisir --</option>
                                @foreach($believers as $b)
                                    <option value="{{ $b->id }}">{{ $b->firstname }} {{ $b->lastname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">Suppléant</div>
                        <div class="col-md-2">
                            <select name="services[{index}][president_backup]" class="form-select">
                                <option value="">--</option>
                                @foreach($believers as $b)
                                    <option value="{{ $b->id }}">{{ $b->firstname }} {{ $b->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- LOUANGE --}}
                    <div class="row mb-2">
                        <div class="col-md-3">Louange</div>
                        <div class="col-md-9">
                            <select name="services[{index}][worship_groups][]" multiple class="form-select">
                                @foreach($groups as $g)
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">CTRL pour multi sélection</small>
                        </div>
                    </div>

                    {{-- ANNONCES --}}
                    <div class="row mb-2">
                        <div class="col-md-3">Annonces</div>
                        <div class="col-md-9">
                            <select name="services[{index}][announcements]" class="form-select">
                                <option value="">-- Choisir --</option>
                                @foreach($believers as $b)
                                    <option value="{{ $b->id }}">{{ $b->firstname }} {{ $b->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </script>

            {{-- SUBMIT --}}
            <div class="mt-4 text-end mb-3">
                <button class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Enregistrer
                </button>

                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Annuler
                </a>
            </div>

        </form>

    </div>

@endsection


@section('scripts')
    <script>
        let index = 0;

        function addService() {
            let template = document.getElementById('service-template').innerHTML;
            template = template.replaceAll('{index}', index);

            document.getElementById('services-container')
                .insertAdjacentHTML('beforeend', template);

            index++;
        }

        function removeService(btn) {
            btn.closest('.service-block').remove();
        }

        // 🔥 IMPORTANT
        document.addEventListener('DOMContentLoaded', function () {
            addService();
        });
    </script>
@endsection