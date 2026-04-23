@extends('layouts.app')

@section('title', 'Nouvelle activité')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <strong><i class="fas fa-plus-circle me-2 text-primary"></i>Nouvelle activité - {{ $team->name }}</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.teams.activities.store', $team) }}" method="POST">
                    @csrf

                    @include('admin.activities.form')

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.teams.activities.index', $team) }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection