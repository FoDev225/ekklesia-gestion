@extends('layouts.app')

@section('title', 'Fidèles - Départs')

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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Liste des departs</h6>
            
            <a href="{{ route('admin.believers.index') }}" class="btn btn-primary"> Liste des fidèles</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom du fidèle</th>
                            <th>Type de départ</th>
                            <th>Date de départ</th>
                            <th>Motif</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($departures as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ optional($d->believer)->firstname }} {{ optional($d->believer)->lastname }}</td>
                                <td>
                                    @if($d->type == 'quit')
                                        <span class="badge badge-warning">Quitter la communauté</span>
                                    @elseif($d->type == 'deceased')
                                        <span class="badge badge-dark">Décédé</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($d->departure_date)?->format('d/m/Y') }}</td>
                                <td>{{ $d->reason }}</td>
                                <td>
                                    @if($d->believer && $d->believer->canBeReintegrated())
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#quitterModal" 
                                            data-toggle="tooltip" data-placement="bottom" title="Quitter la communauté">
                                            Réintégrer
                                        </button>
                                    @endif
                                    
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun depart trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Réintegrer le fidèle -->
                <div class="modal fade" id="quitterModal" tabindex="-1" aria-labelledby="quitterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title text-light text-uppercase" id="quitterModalLabel">Confirmer la réintégration</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Voulez-vous réintegrer le fidèle <strong>{{ $d->believer->lastname }} {{ $d->believer->firstname }}</strong> ?</p>
                            <p class="text-muted mb-0"><small>Cette action réintègre le fidèle dans la communauté.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                            <form action="{{ route('admin.believers.reintegrate', $d->believer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    Confirmer
                                </button>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>

                {{ $departures->links() }}
            </div>
        </div>
        {{-- <a href="" class="btn btn-outline-light text-info">
            <i class="bi bi-arrow-left"></i> Liste des fidèles
        </a> --}}
    </div>

</div>

@endsection