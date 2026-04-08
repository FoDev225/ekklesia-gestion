{{-- RAPPORT D'IMPORT --}}
@if(session('import_report') && count(session('import_report')) > 0)
    <div class="card shadow-sm border-info mt-3 mb-4">
        <div class="card-header bg-info text-white">
            <strong>Rapport d'import</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>Ligne Excel</th>
                        <th>Statut</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('import_report') as $item)
                        <tr>
                            <td>{{ $item['line'] }}</td>
                            <td>
                                @php
                                    $badgeClass = match($item['status']) {
                                        'created' => 'bg-success',
                                        'updated' => 'bg-primary',
                                        'duplicate_skipped' => 'bg-secondary',
                                        'error' => 'bg-danger',
                                        default => 'bg-dark'
                                    };

                                    $label = match($item['status']) {
                                        'created' => 'Créé',
                                        'updated' => 'Mis à jour',
                                        'duplicate_skipped' => 'Doublon ignoré',
                                        'error' => 'Erreur',
                                        default => ucfirst($item['status'])
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                            </td>
                            <td>{{ $item['message'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif