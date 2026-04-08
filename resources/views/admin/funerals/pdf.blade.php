<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title>Registre Funéraire — {{ $funeral->parent_firstname }} {{ $funeral->parent_lastname }}</title>

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
        Registre Funéraire des membres de l'église du Nouveau Bureau
    </h3>

    {{-- ====================== FIDÈLE ENDEUILLÉ ====================== --}}
    <div class="section-title">Fidèle endeuillé</div>
    <div class="card">
        <div><span class="label">Nom :</span> {{ $funeral->believer->firstname }}</div>
        <div><span class="label">Prénom :</span> {{ $funeral->believer->lastname }}</div>
        <div><span class="label">Date de naissance :</span> {{ $funeral->believer->birthdate ?? 'N/A' }}</div>
        <div><span class="label">Lieu de naissance :</span> {{ $funeral->believer->city_of_birth ?? 'N/A' }}</div>
        <div><span class="label">Statut matrimonial :</span> {{ $funeral->believer->marital_status ?? 'N/A' }}</div>
        <div><span class="label">Contact :</span> {{ $funeral->believer->contact ?? 'N/A' }}</div>
    </div>

    {{-- ====================== PARENT DÉCÉDÉ ====================== --}}
    <div class="section-title">Parent décédé</div>
    <div class="card">
        <div><span class="label">Nom :</span> {{ $funeral->parent_firstname }}</div>
        <div><span class="label">Prénom :</span> {{ $funeral->parent_lastname }}</div>
        <div><span class="label">Lien familial :</span> {{ $funeral->family_relationship }}</div>
        <div><span class="label">Cause du décès :</span> {{ $funeral->cause_of_death }}</div>
        <div><span class="label">Date du décès :</span> {{ $funeral->death_date }}</div>
        <div><span class="label">Lieu du décès :</span> {{ $funeral->burial_place }}</div>
    </div>

    {{-- ====================== OBSÈQUES ====================== --}}
    <div class="section-title">Obsèques</div>
    <div class="card">
        <div><span class="label">Date des obsèques :</span> {{ $funeral->funeral_date }}</div>
        <div><span class="label">Lieu des obsèques :</span> {{ $funeral->funeral_place }}</div>
    </div>

    {{-- ====================== ASSISTANCE ÉGLISE ====================== --}}
    <div class="section-title">Assistance de l'église</div>
    <div class="card">
            <div><span class="label">Nombre de pagnes :</span> {{ $funeral->loincloths_number }}</div>
        
            <div><span class="label">Montant numéraire :</span> 
                {{ number_format($funeral->amount_paid, 0, ',', ' ') }} FCFA
            </div>
        
    </div>

    {{-- ====================== ASSISTANCE DES FIDÈLES ====================== --}}
    <div class="section-title">Assistance des fidèles</div>
    <div class="card">
            <div><span class="label">Nombre de pagnes :</span> {{ $funeral->nbre_pagne }}</div>
        
            <div><span class="label">Montant numéraire :</span> 
                {{ number_format($funeral->cash_amount, 0, ',', ' ') }} FCFA
            </div>
        
    </div>

    {{-- ====================== TOTAUX ====================== --}}
    {{-- <div class="section-title">Totaux</div>
    <div class="card">
        @php
            $totalPagnes = $funeral->loincloths_number + $funeral->nbre_pagne;
            $totalArgent = $funeral->amount_paid + $funeral->cash_amount;
        @endphp

        <div><span class="label">Total pagnes :</span> {{ $totalPagnes }}</div>
        <div><span class="label">Total numéraire :</span> {{ number_format($totalArgent, 0, ',', ' ') }} FCFA</div>
    </div> --}}

    {{-- ====================== SIGNATURES ====================== --}}
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:50%; text-align:left; padding-bottom:60px;">
                <div><strong>Signature du fidèle</strong></div>
            </td>
            <td style="width:50%; text-align:right; padding-bottom:60px;">
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
