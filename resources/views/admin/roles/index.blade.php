@extends('layouts.app')

@section('title', 'Liste des rôles')

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
                <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
                
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter un rôle</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Rôle</th>
                                <th>Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($roles as $key => $role)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->code }}</td>
                                <td>
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill" style="font-size: 0.6rem;"></i> Modifier</a>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce rôle ?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill" style="font-size: 0.6rem;"></i> Supprimer
                                        </button>
                                    </form>
                                    
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Aucun rôle créé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $roles->links() }}
                </div>
            </div>
            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection