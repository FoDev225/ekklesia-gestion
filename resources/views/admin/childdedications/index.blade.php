@extends('layouts.app')

@section('title', 'Registre Présentation des Enfants')

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
                <h6 class="m-0 font-weight-bold text-primary">Le registre de présentation des enfants</h6>
                
                <a href="{{ route('admin.child_dedications.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter une fiche</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Père</th>
                                <th>Mère</th>
                                <th>Enfant</th>
                                <th>Genre</th>
                                <th>Date naissance</th>
                                <th>Date présentation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($child_dedications as $key => $dedication)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $dedication->father->lastname }} {{ $dedication->father->firstname }}</td>
                                <td>{{ $dedication->mother->lastname }} {{ $dedication->mother->firstname }}</td>
                                <td>{{ $dedication->child_lastname }} {{ $dedication->child_firstname }}</td>
                                <td>{{ $dedication->gender }}</td>
                                <td>{{ $dedication->child_birthdate->format('d/m/Y') }}</td>
                                <td>{{ $dedication->dedication_date->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.child_dedications.show', $dedication->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill" style="font-size: 0.6rem;"></i> Voir</a>
                                    <a href="{{ route('admin.child_dedications.edit', $dedication->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill" style="font-size: 0.6rem;"></i> Modifier</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucune fiche de présentation des enfants trouvée.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $child_dedications->links() }}
                </div>
            </div>
            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection