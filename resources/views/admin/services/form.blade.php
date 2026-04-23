@extends('layouts.app')

@section('title', 'Programme de cultes')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body">

               <form method="POST" action="{{ route('admin.services.store') }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label>Date</label>
                            <input type="date" name="service_date" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label>Thème</label>
                            <input type="text" name="service_theme" class="form-control">
                        </div>

                    </div>

                    <hr>

                    <h5>Assignation des rôles</h5>

                    @foreach($roles as $role)
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <strong>{{ $role->name }}</strong>
                            </div>

                            <div class="col-md-9">

                                @if(in_array($role->type, ['group']))
                                    <select name="assignments[{{ $role->id }}][group_id]" class="form-select">
                                        <option value="">-- Choisir groupe --</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="assignments[{{ $role->id }}][believer_id]" class="form-select">
                                        <option value="">-- Choisir fidèle --</option>
                                        @foreach($believers as $believer)
                                            <option value="{{ $believer->id }}">
                                                {{ $believer->firstname }} {{ $believer->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                            </div>
                        </div>
                    @endforeach

                    <button class="btn btn-primary mt-3">Créer le culte</button>

                </form> 

            </div>
        </div>
    </div>

@endsection