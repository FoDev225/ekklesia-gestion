@extends('layouts.app')

@section('title', 'Programme de cultes')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">

                <table class="table table-bordered align-middle text-center">

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

                            @php
                                $assignments = $service->assignments;
                            @endphp

                            <tr>
                                <td>
                                    <strong>{{ $service->service_date->format('d/m/Y') }}</strong>
                                </td>

                                <td>{{ $service->theme ?? '-' }}</td>

                                <td>
                                    {{ optional($assignments->firstWhere('role.code','preacher'))->believer->firstname ?? '-' }}
                                </td>

                                <td>
                                    {{ optional($assignments->firstWhere('role.code','president'))->believer->firstname ?? '-' }}
                                </td>

                                <td>
                                    {{ optional($assignments->firstWhere('role.code','worship'))->group->name ?? '-' }}
                                </td>

                                <td>
                                    {{ optional($assignments->firstWhere('role.code','announcements'))->believer->firstname ?? '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8">Aucun culte</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

@endsection