<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Programme des cultes</title>

    <style>
        @page {
            margin: 140px 30px 120px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        /* HEADER */
        .header {
            position: fixed;
            top: -130px;
            left: 0;
            right: 0;
            height: 100px;
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
        }

        /* FOOTER */
        .footer {
            position: fixed;
            bottom: -90px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
        }

        .pagenum:before {
            content: counter(page);
        }

        .signature {
            margin-top: 40px;
            width: 100%;
        }

        .signature td {
            border: none;
            text-align: center;
            padding-top: 50px;
        }

        .text-warning {
            color: #ffc107;
        }

        .fw-bold {
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 4px 6px;
            font-size: 11px;
            border-radius: 4px;
            background-color: #0d6efd;
            color: #fff;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #000;
        }

    </style>
</head>

<body>

{{-- ================= HEADER ================= --}}
<div class="header">
    @php
        $info = \App\Models\ChurchInfo::first();
    @endphp

    <table>
        <tr>
            <td width="20%" style="text-align:right; vertical-align:middle;">
                <img src="{{ public_path('storage/church_photos/1764297073.jpg') }}" alt="Logo">
            </td>

            <td width="80%" style="font-weight:bold;">
                PROGRAMME DES CULTES DE L'EGLISE BAPTISTE AEBECI DE YOPOUGON NOUVEAU BUREAU <br>
                Thème : {{ $selectedPeriode->general_theme ?? '-' }} <br>
                Période : De {{ $selectedPeriode->name ?? '-' }}
            </td>
        </tr>
    </table>
</div>

{{-- ================= TABLE ================= --}}
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Thème</th>
            <th>Prédicateur</th>
            <th>Président</th>
            <th>Louange</th>
            <th>Annonces</th>
            <th>Type</th>
        </tr>
    </thead>

    <tbody>
        @foreach($services as $service)

            @php
                $assignments = $service->assignments;

                $preacherMain = $assignments->firstWhere('role.code','preacher');
                $preacherBackup = $assignments->where('role.code','preacher')->where('is_backup', true)->first();

                $presidentMain = $assignments->firstWhere('role.code','president');
                $presidentBackup = $assignments->where('role.code','president')->where('is_backup', true)->first();
            @endphp

            <tr>
                <td>{{ $service->service_date->format('d/m/Y') }}</td>

                <td>{{ $service->service_theme ?? '-' }}</td>

                <td>
                    {{ $preacherMain->believer->firstname ?? '-' }}
                    {{ $preacherMain->believer->lastname ?? '' }}
                    @if($preacherBackup)
                        <br><small class="text-warning">
                            (Suppléant : {{ $preacherBackup->believer->firstname }} {{ $preacherBackup->believer->lastname }})
                        </small>
                    @endif
                </td>

                <td>
                    {{ $presidentMain->believer->firstname ?? '-' }}
                    {{ $presidentMain->believer->lastname ?? '' }}
                    @if($presidentBackup)
                        <br><small class="text-warning">
                            (Suppléant : {{ $presidentBackup->believer->firstname }} {{ $presidentBackup->believer->lastname }})
                        </small>
                    @endif
                </td>

                <td>
                    @foreach($assignments->where('role.code','worship') as $a)
                        • {{ $a->group->name }} <br>
                    @endforeach
                </td>

                <td>
                    @php
                        $announcer = $assignments->firstWhere('role.code','announcements');
                    @endphp

                    @if($announcer && $announcer->believer)
                        <span>
                            {{ $announcer->believer->firstname }} {{ $announcer->believer->lastname }}
                        </span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                <td>{{ $service->service_type }}</td>
            </tr>

        @endforeach
    </tbody>
</table>

{{-- ================= SIGNATURE ================= --}}
{{-- <table class="signature">
    <tr>
        <td>
            Le Responsable des Cultes <br><br><br>
            _______________________
        </td>

        <td>
            Le Pasteur <br><br><br>
            {{ $info->pastor_name ?? 'Nom du Pasteur' }} <br>
            _______________________
        </td>
    </tr>
</table> --}}

{{-- ================= FOOTER ================= --}}
<div class="footer">
    <p>
        Page <span class="pagenum"></span>
    </p>
</div>

</body>
</html>