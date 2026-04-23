@extends('layouts.app')

@section('title', 'Programme de cultes')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Le registre de mariages</h6>
                
                <a href="" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter une fiche</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Thème</th>
                            <th>Prédicateur</th>
                            <th>Présidence</th>
                            <th>Louange</th>
                            <th>Annonces</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->service_date->format('d/m/Y') }}</td>
                                <td>{{ $service->theme ?? '-' }}</td>

                                {{-- Prédicateur --}}
                                <td>
                                    {{ optional(
                                        $service->assignments->where('role.code', 'preacher')->first()
                                    )->believer->firstname ?? '-' }}
                                </td>

                                {{-- Présidence --}}
                                <td>
                                    {{ optional(
                                        $service->assignments->where('role.code', 'president')->first()
                                    )->believer->firstname ?? '-' }}
                                </td>

                                {{-- Louange --}}
                                <td>
                                    {{ optional(
                                        $service->assignments->where('role.code', 'worship')->first()
                                    )->group->name ?? '-' }}
                                </td>

                                {{-- Annonces --}}
                                <td>
                                    {{ optional(
                                        $service->assignments->where('role.code', 'announcements')->first()
                                    )->believer->firstname ?? '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun culte trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection