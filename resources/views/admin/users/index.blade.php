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
                <h6 class="m-0 font-weight-bold text-primary">Administrateurs</h6>
                
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Créer un compte</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom & Prénom</th>
                                <th>Nom utilisateur</th>
                                <th>Mail</th>
                                <th>Rôles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <button class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deactivateModal"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}">
                                            <i class="bi bi-person-x-fill" style="font-size: 0.6rem;"></i> Désactiver
                                        </button>
                                    @else 
                                        <button class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#activateModal"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}">
                                            <i class="bi bi-person-check-fill" style="font-size: 0.6rem;"></i> Activer
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill" style="font-size: 0.6rem;"></i> Modifier</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Aucun Admin créé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="deactivateModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.deactivate', $user->id) }}" id="deactivateForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Désactiver le compte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Vous êtes sur le point de désactiver :</p>
                        <strong id="modalUserName"></strong>

                        <div class="mt-3">
                            <label>Raison de la désactivation <span class="text-danger">*</span></label>
                            <textarea name="deactivation_reason" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Confirmer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="activateModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.reactivate', $user->id) }}" id="activateForm">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Activer le compte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Vous êtes sur le point d'activer :</p>
                        <strong id="modalUserName"></strong>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Confirmer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection