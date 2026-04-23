@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">
        Modifier objectif annuel
    </h2>

    <form action="{{ route('admin.teams.objectives.update', [$team, $objective]) }}"
          method="POST">
        @csrf
        @method('PUT')

        @include('admin.teams.objectives.partials.form')

        <button class="btn btn-warning">
            Mettre à jour
        </button>

        <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-secondary">
            Retour
        </a>
    </form>

</div>
@endsection