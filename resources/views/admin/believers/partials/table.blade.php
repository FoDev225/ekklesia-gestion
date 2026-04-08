@php

    function highlight($text, $search) {
        if (!$search) return e($text);

        return preg_replace(
            '/' . preg_quote($search, '/') . '/i',
            '<mark>$0</mark>',
            e($text)
        );
    }

@endphp

@forelse($believers as $index => $believer)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $believer->lastname }}</td>
    <td>{{ $believer->firstname }}</td>
    <td>{{ $believer->gender === 'Masculin' ? 'M' : 'F' }}</td>
    <td>
        @php
            $status = $believer->marital_status;
            $class = match($status) {
                'Marié(e)' => 'text-success',
                'Veuf(ve)' => 'text-warning',
                'Divorcé(e)' => 'text-danger',
                'Célibataire' => 'text-info',
                default => '',
            };
        @endphp

        <span class="{{ $class }}">
            {{ $status }}
        </span>
    </td>
    <td>
        @php
            $baptise = $believer->churchInformation?->baptised;

            $class = match($baptise) {
                'Oui' => 'badge bg-success',
                'Non' => 'badge bg-secondary',
                default => ''
            };
        @endphp

        <span class="{{ $class }}">
            {{ $baptise ?? '' }}
        </span>
    </td>
    <td>
        @foreach($believer->groups as $group)
            <span class="badge bg-primary">{{ $group->name }}</span>
        @endforeach
    </td>
    <td>
        @if($believer->disciplinarySituations()->where('status', 'active')->exists())
            <span class="badge badge-danger">
                Sous discipline
            </span>   
        @endif
    </td>
    <td>
        <a href="{{ route('admin.believers.show', $believer->id) }}" class="btn btn-info btn-sm">
            <i class="fas fa-eye"></i>
        </a>

        <a href="{{ route('admin.believers.edit', $believer->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </a>
    </td>
    </tr>
    @empty
    <tr>
        <td colspan="8" class="text-center">Aucun fidèle trouvé.</td>
</tr>
@endforelse
