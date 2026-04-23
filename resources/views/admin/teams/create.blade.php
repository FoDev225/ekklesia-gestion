@extends('layouts.app')

@section('title', 'Créer une équipe')

@section('content')
    <div class="container-fluid py-4">

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-plus-circle me-2"></i>Créer une équipe
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.teams.store') }}" method="POST">
                    @csrf
                    @include('admin.teams._form')

                    <div class="mt-3">
                        <button class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Enregistrer
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