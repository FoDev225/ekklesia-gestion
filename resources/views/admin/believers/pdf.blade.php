<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche du fidèle - {{ $believer->lastname }} {{ $believer->lastname }}</title>
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
        FICHE D'IDENTIFICATION DU FIDÈLE
    </h3>

    {{-- ======================= Section État civil ======================= --}}
    <div class="section-title">ÉTAT CIVIL</div>
    <div class="card">
        <div><span class="label">Matricule :</span> {{ $believer->register_number }}</div>
        <div><span class="label">Nom :</span> {{ $believer->lastname }}</div>
        <div><span class="label">Prénoms :</span> {{ $believer->firstname }}</div>
        <div><span class="label">Civilité :</span> {{ $believer->civility }}</div>
        <div><span class="label">Situation matrimoniale :</span> {{ $believer->marital_status }}</div>
        <div><span class="label">Date de naissance :</span> {{ \Carbon\Carbon::parse($believer->birth_date)->format('d/m/Y') }}</div>
        <div><span class="label">Ville de naissance :</span> {{ $believer->city_of_birth }}</div>
        <div><span class="label">Nombre d’enfants :</span> {{ $believer->number_of_children ?? 0 }}</div>
    </div>

    {{-- ======================= Section Baptême ======================= --}}
    <div class="section-title">BAPTÊME</div>
    <div class="card">
        <div><span class="label">Baptisé(e) :</span> {{ $believer->baptized }}</div>
        <div><span class="label">Date de baptême :</span> {{ $believer->baptism_date ? \Carbon\Carbon::parse($believer->baptism_date)->format('d/m/Y') : '—' }}</div>
        <div><span class="label">Numéro carte de baptême :</span> {{ $believer->baptism_card_number ?? '—' }}</div>
        <div><span class="label">Numéro carte de membre :</span> {{ $believer->membership_card_number ?? '—' }}</div>
        <div><span class="label">Église d’origine :</span> {{ $believer->original_church ?? '—' }}</div>
        <div><span class="label">Année d’arrivée :</span> {{ $believer->arrival_year ?? '—' }}</div>
    </div>

    {{-- ======================= Section Adresse ======================= --}}
    <div class="section-title">ADRESSE ET CONTACT</div>
    <div class="card">
        <div><span class="label">Quartier :</span> {{ $believer->neighborhood }}</div>
        <div><span class="label">Contact principal :</span> {{ $believer->contact }}</div>
        <div><span class="label">Personne à contacter :</span> {{ $believer->person_to_contact }}</div>
        <div><span class="label">Contact à l’église :</span> {{ $believer->contact_at_church ?? '—' }}</div>
        <div><span class="label">Email :</span> {{ $believer->email ?? '—' }}</div>
    </div>

    {{-- ======================= Profession & Formation ======================= --}}
    <div class="section-title">FORMATION & PROFESSION</div>
    <div class="card">
        <div><span class="label">Diplôme :</span> {{ $believer->diplome ?? '—' }}</div>
        <div><span class="label">Profession :</span> {{ $believer->profession }}</div>
        <div><span class="label">Qualification :</span> {{ $believer->qualification ?? '—' }}</div>
    </div>

    {{-- ======================= Situation Disciplinaire ======================= --}}
    {{-- @if($believer->disciplinarySituations->where('status', 'active')->isNotEmpty())
        @php
            $discipline = $believer->disciplinarySituations->where('status', 'active')->first();
        @endphp
            <div class="section-title">SITUATION DISCIPLINAIRE</div>
            <div class="card">
                <div><span class="label">Motif de la sanction :</span> {{ $discipline->reason ?? '—' }}</div>
                <div><span class="label">Date de la mise sous sanction :</span> {{ $discipline->start_date ? \Carbon\Carbon::parse($discipline->start_date)->format('d/m/Y') : '—' }}</div>
                <div><span class="label">Date de fin de la sanction :</span> {{ $discipline->end_date ? \Carbon\Carbon::parse($discipline->end_date)->format('d/m/Y') : 'Décision du conseil' }}</div>
            </div>
    @endif --}}

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
