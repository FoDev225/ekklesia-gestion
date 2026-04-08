<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-primary text-primary text-uppercase">
        <strong>Attribuer à un groupe</strong>
    </div>
    <div class="card-body">
        <div id="groups-wrapper">
            @php
                $oldGroups = old('groups', isset($believer) && $believer->exists
                    ? $believer->groups->map(function ($group) {
                        return [
                            'group_id' => $group->id,
                            'role' => $group->pivot->role,
                            'joined_at' => $group->pivot->joined_at,
                        ];
                    })->toArray()
                    : [[]]
                );
            @endphp

            @foreach($oldGroups as $index => $grp)
                <div class="row align-items-end mb-3 group-row border rounded p-3">
                    <div class="col-md-4">
                        <label class="form-label">Groupe</label>
                        <select name="groups[{{ $index }}][group_id]" class="form-control @error("groups.$index.group_id") is-invalid @enderror">
                            <option value="">-- Sélectionner --</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ old("groups.$index.group_id", $grp['group_id'] ?? '') == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error("groups.$index.group_id")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Rôle</label>
                        <input type="text"
                               name="groups[{{ $index }}][role]"
                               class="form-control @error("groups.$index.role") is-invalid @enderror"
                               value="{{ old("groups.$index.role", $grp['role'] ?? '') }}"
                               placeholder="Ex: Responsable, Membre">
                        @error("groups.$index.role")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Date d’intégration</label>
                        <input type="date"
                               name="groups[{{ $index }}][joined_at]"
                               class="form-control @error("groups.$index.joined_at") is-invalid @enderror"
                               value="{{ old("groups.$index.joined_at", !empty($grp['joined_at']) ? \Carbon\Carbon::parse($grp['joined_at'])->format('Y-m-d') : '') }}">
                        @error("groups.$index.joined_at")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-group w-100">
                            Supprimer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-primary mt-2" id="add-group">
            Ajouter un groupe
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let wrapper = document.getElementById('groups-wrapper');
        let addButton = document.getElementById('add-group');

        if (addButton && wrapper) {
            addButton.addEventListener('click', function () {
                let index = wrapper.querySelectorAll('.group-row').length;

                let newRow = `
                    <div class="row align-items-end mb-3 group-row border rounded p-3">
                        <div class="col-md-4">
                            <label class="form-label">Groupe</label>
                            <select name="groups[${index}][group_id]" class="form-control">
                                <option value="">-- Sélectionner --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Rôle</label>
                            <input type="text" name="groups[${index}][role]" class="form-control" placeholder="Ex: Responsable, Membre">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date d’intégration</label>
                            <input type="date" name="groups[${index}][joined_at]" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-group w-100">
                                Supprimer
                            </button>
                        </div>
                    </div>
                `;

                wrapper.insertAdjacentHTML('beforeend', newRow);
            });

            wrapper.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-group')) {
                    e.target.closest('.group-row').remove();
                }
            });
        }
    });
</script>