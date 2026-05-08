@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header">
                <h4>
                    <i class="fas fa-bullseye me-1"></i>
                    Objectif annuel — {{ $team->name }}
                </h4>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.teams.objectives.store', $team) }}" method="POST">
                @csrf

                @include('admin.teams.objectives.partials.form')

                <button class="btn btn-success">
                    Enregistrer
                </button>

                <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-secondary">
                    Retour
                </a>
            </form>
        </div>

</div>
@endsection