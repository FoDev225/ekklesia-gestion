@extends('layouts.app')

@section('title', 'Informations de l\'église')

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
                <h6 class="m-0 font-weight-bold text-primary">Informations de l'église</h6>
                <a href="{{ route('admin.church_info.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter des infos</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Organisation</th>
                                <th>District</th>
                                <th>Eglise locale</th>
                                <th>Contacts</th>
                                <th>localisation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($churchInfo as $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->organisation_name }}</td>
                                <td>{{ $data->district }}</td>
                                <td>{{ $data->church_name }}</td>
                                <td>{{ $data->pastor_phone_number }} - {{ $data->pastor_phone_number }}</td>
                                <td>{{ $data->localisation }}</td>
                                <td>
                                    <a href="{{ route('admin.church_info.show', $data->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="bottom" title="Voir plus d'infos">
                                        <i class="bi bi-eye-fill" style="font-size: 0.6rem;"></i> Voir
                                    </a>
                                    <a href="{{ route('admin.church_info.edit', $data->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Modifier les infos">
                                        <i class="bi bi-pencil-fill" style="font-size: 0.6rem;"></i> Modifier</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune information d'église trouvée.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $churchInfo->links() }}
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection