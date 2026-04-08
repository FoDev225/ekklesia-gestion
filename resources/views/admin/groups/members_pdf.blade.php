<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Membres du groupe</title>
    <style>
        @page {
            margin: 140px 30px 120px 30px; /* top - right - bottom - left */
        }
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
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

            text-align: center;
            margin-top: 0;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .header table td {
            border: none;
            padding: 0;
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
    {{-- ======================= En-tête ======================= --}}
    <div class="header">
        <table>
            <tr>
                @php
                    $info = App\Models\ChurchInfo::first();
                @endphp
                <td width="20%" style="text-align:right; vertical-align:middle;">
                    <img src="{{ public_path('storage/church_photos/1764297073.jpg') }}" alt="Logo">
                </td>
                
                <td width="80%" style="text-align:left; padding-left:15px;">
                    <h3 style="color:#000; text-align:center;">{{ $info->organisation_name ?? '' }}</h3>
                    <h4 style="color:111; text-align:center;">{{ $info->district ?? '' }} - EGLISE LOCALE {{ $info->church_name ?? '' }}</h4>
                    <h4 style="color:111; text-align:center;">Autorisation N° : {{ $info->authorization ?? '' }}</h4>
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <h2>Liste des membres du groupe : {{ $group->name }}</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom(s)</th>
                <th>Sexe</th>
                <th>Date de naissance</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Date d’intégration</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $i => $believer)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $believer->lastname }}</td>
                    <td>{{ $believer->firstname }}</td>
                    <td>{{ $believer->gender }}</td>
                    <td>{{ $believer->birth_date ? \Carbon\Carbon::parse($believer->birth_date)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $believer->address->whatsapp_number ?? '-' }}</td>
                    <td>{{ $believer->pivot->role ?? '-' }}</td>
                    <td>
                        {{ $believer->pivot->joined_at ? \Carbon\Carbon::parse($believer->pivot->joined_at)->format('d/m/Y') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Aucun membre trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ======================= Pied de page ======================= --}}
    <div class="footer">
        <hr>
        <p style="color:111; text-align:center; font-size:11px;">
            Temple de {{ $info->church_name ?? '' }} - 
            Adresse postal : {{ $info->address ?? '' }} - 
            Tel : {{ $info->pastor_phone_number ?? '' }} ; {{ $info->secretary_phone_number ?? '' }} - 
            Email : {{ $info->church_email ?? '' }} ; {{ $info->pastor_email ?? '' }} - 
            Situation géographique : {{ $info->localisation ?? '' }}.
        </p>
        <div style="text-align:center; font-size:11px; color:#777;">
            <p>
                --------------------------------------- <br>
                <p>Fiche générée le {{ now()->format('d/m/Y à H:i') }}</p>
            </p>
            
        </div>
    </div>
</body>
</html>