@extends('layouts.app')

@section('title', 'Modifier une équipe')

@section('content')
    <div class="container-fluid py-4">

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold text-warning">
                    <i class="fas fa-edit me-2"></i>Modifier l’équipe
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.teams.update', $team) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('admin.teams._form')

                    <div class="mt-3">
                        <button class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Mettre à jour
                        </button>

                        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
                            Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection