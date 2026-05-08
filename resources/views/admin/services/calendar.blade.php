@extends('layouts.app')

@section('title', 'Calendrier des cultes')

@section('content')

    @php
        $assignments = $service?->assignments ?? collect();

        $preacher = optional($assignments->firstWhere('role.code','preacher'))->believer->firstname ?? '-';
        $president = optional($assignments->firstWhere('role.code','president'))->believer->firstname ?? '-';
        $announcer = optional($assignments->firstWhere('role.code','announcements'))->believer->firstname ?? '-';

        $groups = $assignments->where('role.code','worship')
                    ->pluck('group.name')
                    ->implode(', ');
    @endphp

    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-4">
            <h4 class="fw-bold">
                Calendrier des cultes
            </h4>

            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-calendar-alt me-1"></i> Voir le tableau des cultes
            </a>
        </div>

        <div class="row mb-4">

                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <strong>
                                <i class="fas fa-church me-2"></i>
                                Programme du dimanche ({{ $nextSunday->format('d/m/Y') }})
                            </strong>
                            <div>
                                @php
                                    $day = now()->dayOfWeek; // 0=dimanche, 2=mardi
                                @endphp

                                @if($day >= 2 && $day < 6)
                                    <span class="badge bg-info animate__animated animate__pulse animate__infinite p-2">
                                        Préparation en cours
                                    </span>
                                @elseif($day == 6)
                                    <span class="badge bg-warning text-dark animate__animated animate__pulse animate__infinite p-2">
                                        Finalisation
                                    </span>
                                @elseif($day == 0)
                                    <span class="badge bg-primary animate__animated animate__pulse animate__infinite p-2">Aujourd’hui</span>
                                @endif

                                @php
                                    $message = cache('whatsapp_message');
                                @endphp
                                @if($message)
                                    <a href="https://wa.me/?text={{ urlencode($message) }}" target="_blank" class="btn btn-success">
                                        <i class="fab fa-whatsapp me-1"></i> Envoyer le programme
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">

                            @if(now()->isTuesday())
                                <div class="alert alert-success mb-3 text-center">
                                    Le programme du dimanche est prêt à être envoyé 📲
                                </div>
                            @endif

                            @if($services)

                                <div class="row text-center">

                                    <div class="col-md-3">
                                        <small class="text-muted">Thème</small>
                                        <h6 class="fw-bold">{{ $nextService->service_theme ?? '-' }}</h6>
                                    </div>

                                    <div class="col-md-2">
                                        <small class="text-muted">Prédicateur</small>
                                        <h6 class="fw-bold text-primary">
                                            <i class="fas fa-microphone me-1"></i> {{ $preacher }}
                                        </h6>
                                    </div>

                                    <div class="col-md-2">
                                        <small class="text-muted">Président</small>
                                        <h6 class="fw-bold text-success">
                                            <i class="fas fa-user-tie me-1"></i> {{ $president }}
                                        </h6>
                                    </div>

                                    <div class="col-md-3">
                                        <small class="text-muted">Louange</small>
                                        <h6 class="fw-bold text-warning">
                                            <i class="fas fa-music me-1"></i> {{ $groups ?: '-' }}
                                        </h6>
                                    </div>

                                    <div class="col-md-2">
                                        <small class="text-muted">Annonce</small>
                                        <h6 class="fw-bold text-dark">
                                            <i class="fas fa-bullhorn me-1"></i> {{ $announcer }}
                                        </h6>
                                    </div>

                                </div>

                            @else
                                <p class="text-muted text-center">
                                    Le programme n'est pas encore disponible pour ce dimanche.
                                </p>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div id="calendar"></div>

            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

        let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {

            initialView: 'dayGridMonth',
            height: 650,
            events: @json($events),

            editable: true,

            eventContent: function(arg) {
                let preacher = arg.event.extendedProps.preacher ?? '';
                let groups = arg.event.extendedProps.groups ?? '';

                return {
                    html: `
                        <div style="font-size:12px">
                            <strong>${arg.event.title}</strong><br>
                            👤 ${preacher}<br>
                            🎶 ${groups}
                        </div>
                    `
                };
            },

            eventDidMount: function(info) {
                let preacher = info.event.extendedProps.preacher ?? '';
                let groups = info.event.extendedProps.groups ?? '';

                info.el.setAttribute(
                    'title',
                    `Prédicateur: ${preacher} | Groupes: ${groups}`
                );
            },

            eventDrop: function(info) {
                updateDate(info.event);
            },

            eventClick: function(info) {
                window.location.href = `/admin/services/${info.event.id}`;
            }

        });

        calendar.render();
    });

        function updateDate(event) {

            fetch(`/admin/services/${event.id}/update-date`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    date: event.startStr
                })
            });
        }
    </script>

@endsection