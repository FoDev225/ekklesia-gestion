<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport annuel d'activités</title>

    <style>
        @page {
            margin: 140px 30px 120px 30px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #333;
            padding: 6px;
        }

        table th {
            background: #f2f2f2;
        }

        .header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            height: 80px;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .header td {
            border: none;
        }

        .header img {
            width: 80px;
            height: 80px;
        }

        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 70px;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- ======================= HEADER ======================= --}}
<div class="header">
    <table>
        <tr>
            @php
                $info = App\Models\ChurchInfo::first();
            @endphp

            <td width="20%" style="text-align:right;">
                <img src="{{ public_path('storage/church_photos/1764297073.jpg') }}">
            </td>

            <td width="80%" style="text-align:center;">
                <h3>{{ $info->organisation_name ?? '' }}</h3>
                <h4>{{ $info->district ?? '' }} - EGLISE LOCALE {{ $info->church_name ?? '' }}</h4>
                <h4>Autorisation N° : {{ $info->authorization ?? '' }}</h4>
            </td>
        </tr>
    </table>
    <hr>
</div>

{{-- ======================= TITRE ======================= --}}
<h2>RAPPORT ANNUEL D’ACTIVITÉS</h2>

<div class="section">
    <p><strong>Équipe :</strong> {{ $team->name }}</p>
    <p><strong>Objectif :</strong> {{ $objective->main_goal ?? '-' }}</p>
    <p>
        <strong>Période :</strong> 
        {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}
    </p>
</div>

{{-- ======================= KPI ======================= --}}
<div class="section">
    <h3>Statistiques</h3>

    <table>
        <tr>
            <th>Total activités</th>
            <th>Réalisées</th>
            <th>Taux (%)</th>
            <th>Dépenses (FCFA)</th>
        </tr>
        <tr>
            <td>{{ $totalActivities }}</td>
            <td>{{ $completedActivities }}</td>
            <td>{{ $completionRate }}%</td>
            <td>{{ number_format($totalExpenses, 0, ',', ' ') }}</td>
        </tr>
    </table>
</div>

{{-- ======================= ACTIVITÉS ======================= --}}
<div class="section">
    <h3>Liste des activités</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Activité</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Dépense</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $i => $activity)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $activity->title }} :</strong> {{ $activity->theme }}</td>
                    <td>{{ $activity->scheduled_date?->format('d/m/Y') }}</td>
                    <td>
                        @php
                            $label = match($activity->status) {
                                'scheduled' => 'Prévu',
                                'completed' => 'Terminé',
                                'canceled'  => 'Annulé',
                                default => 'Inconnu'
                            };

                            $badge = match($activity->status) {
                                'scheduled' => 'bg-secondary',
                                'completed' => 'bg-success',
                                'canceled'  => 'bg-danger',
                                default => 'bg-dark'
                            };  
                        @endphp

                        <span class="badge {{ $badge }}">{{ $label }}</span>
                    </td>
                    <td>
                        {{ number_format($activity->expenses->sum('amount'), 0, ',', ' ') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Aucune activité trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ======================= FOOTER ======================= --}}
<div class="footer">
    <hr>
    <p style="font-size:11px;">
        Temple de {{ $info->church_name ?? '' }} -
        Adresse : {{ $info->address ?? '' }} -
        Tel : {{ $info->pastor_phone_number ?? '' }} ; {{ $info->secretary_phone_number ?? '' }} -
        Email : {{ $info->church_email ?? '' }} ; {{ $info->pastor_email ?? '' }} - 
        Situation géographique : {{ $info->localisation ?? '' }}.
    </p>

    <p style="font-size:11px; color:#777;">
        Rapport généré le {{ now()->format('d/m/Y à H:i') }}
    </p>
</div>

</body>
</html>