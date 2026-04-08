<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche du fidèle - {{ $mariage->groom->lastname }} {{ $mariage->bride->lastname }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

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
            margin-top: 10px;
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
        FICHE DE MARIAGE
    </h3>

    {{-- ======================= Section Mariage ======================= --}}
    <div class="section-title">MARIAGE DE</div>
    <div class="card">
        <table>
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $mariage->groom_photo) }}" alt="Photo de {{ $mariage->groom->lastname }}" class="img-fluid rounded" style="max-height: 200px;">
                </td>
                <td>
                    <img src="{{ asset('storage/' . $mariage->bride_photo) }}" alt="Photo de {{ $mariage->bride->lastname }}" class="img-fluid rounded" style="max-height: 200px;">
                </td>
            </tr>
        </table>
    </div>

    {{-- ======================= MARIES ======================= --}}
    {{-- <div class="section-title">LES MARIES</div> --}}
    <div class="card">
        <table>
            <tr>
                <td style="vertical-align: top; padding-right: 20px;">
                    <h4 style="text-transform:uppercase; margin-bottom:10px;">
                        LE MARIÉ
                    </h4>
                    <p><span class="label">Nom & Prénoms :</span> {{ $mariage->groom->lastname }} {{ $mariage->groom->firstname }}</p>
                    <p><span class="label">Date & Lieu de naissance :</span> {{ \Carbon\Carbon::parse($mariage->groom->birth_date)->format('d/m/Y') }} à {{ $mariage->groom->city_of_birth }}</p>
                    <p><span class="label">Baptisé le :</span> {{ \Carbon\Carbon::parse($mariage->groom->baptism_date)->format('d/m/Y') }} à {{ $mariage->groom->baptism_place }}</p>
                    <p><span class="label">Par :</span> {{ $mariage->groom->baptism_by }}</p>
                    <p><span class="label">Profession :</span> {{ $mariage->groom->profession }}</p>
                </td>
                <td style="vertical-align: top; padding-left: 20px;">
                    <h4 style="text-transform:uppercase; margin-bottom:10px;">
                        LA MARIÉE
                    </h4>
                    <p><span class="label">Nom & Prénoms :</span> {{ $mariage->bride->lastname }} {{ $mariage->bride->firstname }}</p>
                    <p><span class="label">Date & Lieu de naissance :</span> {{ \Carbon\Carbon::parse($mariage->bride->birth_date)->format('d/m/Y') }} à {{ $mariage->bride->city_of_birth }}</p>
                    <p><span class="label">Baptisé le :</span> {{ \Carbon\Carbon::parse($mariage->bride->baptism_date)->format('d/m/Y') }} à {{ $mariage->bride->baptism_place }}</p>
                    <p><span class="label">Par :</span> {{ $mariage->bride->baptism_by }}</p>
                    <p><span class="label">Profession :</span> {{ $mariage->bride->profession }}</p>
                </td>
        </table>
    </div>

    {{-- ======================= CEREMONIE CIVILE ======================= --}}
    <div class="section-title">CEREMONIE CIVILE</div>
    <div class="card">
        <table>
            <tr>
                <td style="vertical-align: top; padding-right: 20px;">
                    <p><span class="label">Date :</span> {{ \Carbon\Carbon::parse($mariage->civil_marriage_date)->format('d/m/Y') }}</p>
                    
                </td>
                <td style="vertical-align: top; padding-left: 20px;">
                    <p><span class="label">Lieu :</span> {{ $mariage->civil_marriage_place }}</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- ======================= CEREMONIE RELIGIEUSE ======================= --}}
    <div class="section-title">CEREMONIE RELIGIEUSE</div>
    <div class="card">
        <table>
            <tr>
                <td style="vertical-align: top; padding-right: 20px;">
                    <p><span class="label">Date :</span> {{ \Carbon\Carbon::parse($mariage->religious_marriage_date)->format('d/m/Y') }}</p>
                    <p><span class="label">Dirigeant :</span> {{ $mariage->wedding_mc }}</p>
                    <p><span class="label">Dirigeant :</span> {{ $mariage->hand_bible }}</p>
                    
                </td>
                <td style="vertical-align: top; padding-left: 20px;">
                    <p><span class="label">Lieu :</span> {{ $mariage->religious_marriage_place }}</p>
                    <p><span class="label">Prédicateur :</span> {{ $mariage->wedding_preacher }}</p>
                    <p><span class="label">Prédicateur :</span> {{ $mariage->officiant }}</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- ======================= TEMOINS ======================= --}}
    <div class="section-title">TEMOINS</div>
    <div class="card">
        <table>
            <tr>
                <td style="vertical-align: top; padding-right: 20px;">
                    <h4 style="text-transform:uppercase; margin-bottom:10px;">
                        Témoin Epoux
                    </h4>
                    <p><span class="label">Nom & Prénoms :</span> {{ $mariage->groom_witness }}</p>
                    <p><span class="label">Profession :</span> {{ $mariage->groom_witness_profession }}</p>
                </td>
                <td style="vertical-align: top; padding-left: 20px;">
                    <h4 style="text-transform:uppercase; margin-bottom:10px;">
                        Témoin Epouse
                    </h4>
                    <p><span class="label">Nom & Prénoms :</span> {{ $mariage->bride_witness }}</p>
                    <p><span class="label">Profession :</span> {{ $mariage->bride_witness_profession }}</p>
                </td>
            </tr>
        </table>
    </div>

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
            --------------------------------------- <br>
            <p>Fiche générée le {{ now()->format('d/m/Y à H:i') }}</p>
            
        </div>
    </div>

</body>
</html>
