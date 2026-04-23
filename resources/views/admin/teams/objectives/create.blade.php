@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">
        Nouvel objectif annuel — {{ $team->name }}
    </h2>

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
@endsection