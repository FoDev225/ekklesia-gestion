@extends('layouts.app')

@section('title', 'Sanctions disciplinaires')

@section('content')

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Liste des sanctions</h6>
            
            <a href="{{ route('admin.believers.index') }}" class="btn btn-primary"> Liste des fidèles</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom du fidèle</th>
                            <th>Motif</th>
                            <th>Date de discipline</th>
                            <th>Fin discipline</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($sanctions as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ optional($d->believer)->firstname }} {{ optional($d->believer)->lastname }}</td>
                                <td>{{ $d->reason }}</td>
                                <td>{{ \Carbon\Carbon::parse($d->start_date)?->format('d/m/Y') }}</td>
                                <td>
                                    @if($d->end_date)
                                        {{ \Carbon\Carbon::parse($d->end_date)?->format('d/m/Y') }}
                                    @else
                                        <span class="badge bg-warning text-dark p-1">
                                            Décision Conseil
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($d->status == 'active')
                                        <span class="badge badge-danger p-1">En cours</span>
                                    @else 
                                        <span class="badge badge-success p-1">Discipline levée</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune sanction disciplinaire trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $sanctions->links() }}
            </div>
        </div>
        {{-- <a href="" class="btn btn-outline-light text-info">
            <i class="bi bi-arrow-left"></i> Liste des fidèles
        </a> --}}
    </div>

</div>

@endsection