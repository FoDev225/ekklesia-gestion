@extends('layouts.app')

@section('title', 'Gestion des fidèles')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

       {{-- MESSAGE SUCCÈS --}}
       @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('report'))
            <div class="alert alert-danger">
                {{ session('report') }}
            </div>
        @endif

        {{-- DÉTAIL DES ERREURS UNIQUEMENT --}}
        @if(session('import_report'))
            @php
                $errors = collect(session('import_report'))->where('status', 'Erreur');
            @endphp

            @if($errors->count())
                <div class="alert alert-danger">
                    <h5 class="mb-3">❌ Erreurs d’import détectées :</h5>

                    <ul class="mb-0">
                        @foreach($errors as $error)
                            <li class="mb-2">
                                <strong>Ligne {{ $error['line'] }}</strong>
                                @if(!empty($error['name']))
                                    — {{ $error['name'] }}
                                @endif

                                <ul class="mt-1">
                                    @foreach($error['errors'] ?? [] as $msg)
                                        <li>{{ $msg }}</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif

        @include('admin.believers.partials.import_rapport')

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <!-- Titre à gauche -->
                    <div class="col-md-2">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Liste des fidèles
                        </h6>
                    </div>
                    
                     <div class="col-md-10 text-md-right">
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <!-- Recherche -->
                            <div>
                                <input type="text"
                                        id="live-search"
                                        class="form-control bg-light border-primary small"
                                        placeholder="Rechercher un fidèle..."
                                        autocomplete="off">
                            </div>

                            <!-- Importer / Ajouter -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal" 
                            data-toggle="tooltip" data-placement="bottom" title="Importer un fichier Excel">
                                Importer Excel
                            </button>
                            @include('admin.believers.modal.import')

                            <!-- Export -->
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exportModal" 
                            data-toggle="tooltip" data-placement="bottom" title="Exporter un fichier Excel">
                                Export Excel
                            </button>
                            @include('admin.believers.modal.export')

                            <!-- Ajouter -->
                            <a href="{{ route('admin.believers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Ajouter un fidèle
                            </a>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Genre</th>
                                <th>Situation maritale</th>
                                <th>Batisé(e)</th>
                                <th>Groupes</th>
                                <th>Sanction</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody id="believers-table">
                            @include('admin.believers.partials.table', ['believers' => $believers])
                        </tbody>

                    </table>
                    <div class="mt-3" id="pagination-links">
                        {{ $believers->links() }}
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.believers.statistics') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au tableau de bord
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->
<script>
    let timeout = null;

    document.getElementById('live-search').addEventListener('keyup', function () {
        clearTimeout(timeout);
        let query = this.value;

        timeout = setTimeout(() => {
            fetch(`{{ route('admin.believers.search') }}?search=${query}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('believers-table').innerHTML = html;
                    document.getElementById('pagination-links').style.display = query ? 'none' : 'block';
                });
        }, 300);
    });
</script>

@endsection