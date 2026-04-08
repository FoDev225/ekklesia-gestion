<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Demande de présentation — {{ $child_dedication->child_lastname }} {{ $child_dedication->child_firstname }}</title>

    <style>
        @page {
            margin: 140px 30px 120px 30px; /* top - right - bottom - left */
        }
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            line-height: 1.4;
        }

        h2, h3, h4 {
            margin: 0;
            padding: 0;
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

        .header img {
            width: 80px;
            height: 80px;
        }
        .section-title {
            background: #f2f2f2;
            padding: 8px 12px;
            font-weight: bold;
            margin-bottom: 8px;
            border-left: 4px solid #444;
            text-transform: uppercase;
        }
        .card {
            border: 1px solid #ccc;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 4px;
        }
        .row { width: 100%; display: flex; justify-content: space-between; }
        .col-6 { width: 48%; }
        .col-4 { width: 31%; }
        .label { font-weight: bold; }
        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }
        .signature-block {
            flex: 1;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 70px;
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

    <h3 style="text-align:center; text-transform:uppercase; margin-bottom:20px;">
        Demande de présentation d'enfant
    </h3>

    {{-- ====================== FIDÈLE ENDEUILLÉ ====================== --}}
    <div class="card" style="margin-bottom:30px;">
        <p style="text-align:left;">Abidjan, le {{ $child_dedication->demande_date->format('d/m/Y') }}</p>
        <div>
            <p>Monsieur <span style="font-weight:bold;">{{ $child_dedication->father->lastname }} {{ $child_dedication->father->firstname }}</span> et Madame <span style="font-weight:bold;">{{ $child_dedication->mother->lastname }} {{ $child_dedication->mother->firstname }}</span> Mariés le 
            <span style="font-weight: bold;">{{ optional($child_dedication->father->marriage_date)->format('d/m/Y') }}</span> à <span style="font-weight: bold;">{{ $child_dedication->father->marriage_place }}</span>.
            
            <p>Sommes reconnaissants que le Seigneur nous ait fait don d'un enfant de sexe <span style="font-weight: bold;"> {{ $child_dedication->gender }}</span></p>
            
            <p>Que nous avons nommé 
            <span style="font-weight: bold;">{{ $child_dedication->child_lastname }} {{ $child_dedication->child_firstname }}</span>. </p> 
            <p>
                Il/elle est né(e) le
                <span style="font-weight: bold;">{{ optional($child_dedication->child_birthdate)->format('d/m/Y') }}</span> à <span style="font-weight: bold;">{{ $child_dedication->child_birthplace }}</span>.
            </p>

            <p>Nous voudrions le présenter à Dieu pour lui exprimer toute notre gratitude et lui demander de nous aider à assumer notre responsabilité quant à son éducation.</p>

            <p style="font-weight: bold;">Date de présentation : {{ optional($child_dedication->dedication_date)->format('d/m/Y') }}</p>
        </div>
    </div>

    {{-- ====================== PERE & MERE ====================== --}}
    <div class="card" style="margin-bottom:30px;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="margin-bottom:20px">
                    <th style="width:50%; text-align:left;">Le père</th>
                    <th style="width:50%; text-align:left;">La mère</th>
                </tr>
            </thead>
            <tbody>
                <tr style="margin-bottom:20px">
                    <td><strong>Nom :</strong> {{ $child_dedication->father->lastname ?? 'N/A' }}</td>
                    <td><strong>Nom :</strong> {{ $child_dedication->mother->lastname ?? 'N/A' }}</td>
                </tr>

                <tr style="margin-bottom:20px">
                    <td><strong>Prénoms :</strong> {{ $child_dedication->father->firstname ?? 'N/A' }}</td>
                    <td><strong>Prénoms :</strong> {{ $child_dedication->mother->firstname ?? 'N/A' }}</td>
                </tr>

                <tr style="margin-bottom:20px">
                    <td>
                        <strong>Date de naissance :</strong>
                        {{ optional($child_dedication->father?->believer_birthdate)->format('d/m/Y') ?? 'N/A' }}
                    </td>
                    <td>
                        <strong>Date de naissance :</strong>
                        {{ optional($child_dedication->mother?->believer_birthdate)->format('d/m/Y') ?? 'N/A' }}
                    </td>
                </tr>

                <tr style="margin-bottom:20px">
                    <td><strong>Baptisé :</strong>{{ optional($child_dedication->father->baptism_date)->format('d/m/Y') }}</td>
                    <td><strong>Baptisé :</strong> {{ optional($child_dedication->mother->baptism_date)->format('d/m/Y') }}</td>
                </tr>

                <tr style="margin-bottom:20px">
                    <td><strong>N° carte de membre :</strong> {{ $child_dedication->father->membership_card_number ?? 'N/A' }}</td>
                    <td><strong>N° carte de membre :</strong> {{ $child_dedication->mother->membership_card_number ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

    </div>

    {{-- ====================== SIGNATURES ====================== --}}
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:50%; text-align:left; padding-bottom:60px;">
                <div><strong>Signature du père</strong></div>
            </td>
            <td style="width:50%; text-align:right; padding-bottom:60px;">
                <div><strong>Signature de la mère</strong></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:50%; text-align:center; padding-bottom:60px;">
                <div><strong>Signature du pasteur</strong></div>
            </td>
        </tr>
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
