@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Modifier le groupe</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.groups.update', $group) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.groups._form')
                </form>
            </div>
        </div>
    </div>
@endsection