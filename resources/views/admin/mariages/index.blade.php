@extends('layouts.app')

@section('title', 'Registre de mariages')

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
                <h6 class="m-0 font-weight-bold text-primary">Le registre de mariages</h6>
                
                <a href="{{ route('admin.mariages.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter une fiche</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Le fiancé</th>
                                <th>La fiancée</th>
                                <th>Date mariage</th>
                                <th>Lieu mariage</th>
                                <th>Pasteur officiant</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($mariages as $key => $mariage)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $mariage->groom->firstname }} {{ $mariage->groom->lastname }}</td>
                                <td>{{ $mariage->bride->firstname }} {{ $mariage->bride->lastname }}</td>
                                <td>{{ $mariage->religious_marriage_date->format('d/m/Y') }}</td>
                                <td>{{ $mariage->religious_marriage_place }}</td>
                                <td>{{ $mariage->officiant }}</td>
                                <td>
                                    <a href="{{ route('admin.mariages.show', $mariage->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill" style="font-size: 0.6rem;"></i> Voir</a>
                                    <a href="{{ route('admin.mariages.edit', $mariage->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill" style="font-size: 0.6rem;"></i> Modifier</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun enregistrement trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $mariages->links() }}
                </div>
            </div>
            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection