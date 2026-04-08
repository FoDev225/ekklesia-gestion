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
                <h6 class="m-0 font-weight-bold text-primary">Historique des Connexions</h6>
                
                {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Créer un compte</a> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Utilisateur</th>
                                <th>IP</th>
                                <th>Navigateur</th>
                                <th>Connexion</th>
                                <th>Déconnexion</th>
                                <th>Succès</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($logs as $key => $log)
                            <tr>
                                <td>{{ $key + 1}}</td>
                                <td>{{ $log->user->name }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ $log->user_agent }}</td>
                                <td>{{ $log->logged_in_at }}</td>
                                <td>{{ $log->logged_out_at }}</td>
                                <td>
                                    @if($log->successful)
                                        <span class="badge badge-success">Succès</span>
                                    @else
                                        <span class="badge badge-danger">Échec</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun Journal.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $logs->links() }}
                </div>
            </div>
            <a href="{{ route('admin.menu.dashboard') }}" class="btn btn-outline-light text-info">
                <i class="bi bi-arrow-left"></i> Retour au Menu
            </a>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection