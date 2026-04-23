@extends('layouts.app')

@section('title', 'Modifier activité')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <strong><i class="fas fa-edit me-2 text-warning"></i>Modifier activité - {{ $team->name }}</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.teams.activities.update', [$team, $activity]) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.activities.form')

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.teams.activities.index', $team) }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection