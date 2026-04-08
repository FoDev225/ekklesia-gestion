@extends('layouts.app')

@section('title', 'Registre Funeraire')

@section('content')

    <!-- Begin Page Content -->
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
                <h6 class="m-0 font-weight-bold text-primary">Le registre funeraire</h6>
                
                <a href="{{ route('admin.funerals.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter une fiche</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénom fidèle</th>
                                <th>Contact fidèle</th>
                                <th>Parent décédé</th>
                                <th>Date décès</th>
                                <th>Lien familial</th>
                                <th>Date des funérailles</th>
                                <th>Lieu des funérailles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($funerals as $key => $funeral)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $funeral->believer->firstname }} {{ $funeral->believer->lastname }}</td>
                                <td>{{ $funeral->believer->contact }}</td>
                                <td>{{ $funeral->parent_firstname }} {{ $funeral->parent_lastname }}</td>
                                <td>{{ $funeral->death_date }}</td>
                                <td>{{ $funeral->family_relationship }}</td>
                                <td>{{ $funeral->funeral_date }}</td>
                                <td>{{ $funeral->funeral_place }}</td>
                                <td>
                                    <a href="{{ route('admin.funerals.show', $funeral->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill" style="font-size: 0.6rem;"></i> Voir</a>
                                    <a href="{{ route('admin.funerals.edit', $funeral->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill" style="font-size: 0.6rem;"></i> Modifier</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Aucun enregistrement trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $funerals->links() }}
                </div>
            </div>
            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection