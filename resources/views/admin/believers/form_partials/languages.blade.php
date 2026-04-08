<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Langues</strong>
    </div>
    <div class="card-body">
        <div id="languages-wrapper">
            @php
                $oldLanguages = old('languages', isset($believer) && $believer->exists
                    ? $believer->languages->map(function ($language) {
                        return [
                            'language_id' => $language->id,
                            'spoken' => $language->pivot->spoken,
                            'written' => $language->pivot->written,
                        ];
                    })->toArray()
                    : [[]]
                );
            @endphp

            @foreach($oldLanguages as $index => $lang)
                <div class="row align-items-end mb-3 language-row border rounded p-3">
                    <div class="col-md-3">
                        <label class="form-label">Langue parlée</label>
                        <select name="languages[{{ $index }}][language_id]" class="form-control @error("languages.$index.language_id") is-invalid @enderror">
                            <option value="">-- Sélectionner --</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}"
                                    {{ old("languages.$index.language_id", $lang['language_id'] ?? '') == $language->id ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                            @endforeach
                        </select>
                        @error("languages.$index.language_id")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label d-block">Lue</label>
                        <div class="form-check">
                            <input type="checkbox"
                                   name="languages[{{ $index }}][spoken]"
                                   value="1"
                                   class="form-check-input"
                                   {{ old("languages.$index.spoken", $lang['spoken'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label">Oui</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label d-block">Écrite</label>
                        <div class="form-check">
                            <input type="checkbox"
                                   name="languages[{{ $index }}][written]"
                                   value="1"
                                   class="form-check-input"
                                   {{ old("languages.$index.written", $lang['written'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label">Oui</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger remove-language w-100">
                            Supprimer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-primary mt-2" id="add-language">
            Ajouter une langue
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let wrapper = document.getElementById('languages-wrapper');
        let addButton = document.getElementById('add-language');

        addButton.addEventListener('click', function () {
            let index = wrapper.querySelectorAll('.language-row').length;

            let newRow = `
                <div class="row align-items-end mb-3 language-row border rounded p-3">
                    <div class="col-md-3">
                        <label class="form-label">Langue parlée</label>
                        <select name="languages[${index}][language_id]" class="form-control">
                            <option value="">-- Sélectionner --</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label d-block">Lue</label>
                        <div class="form-check">
                            <input type="checkbox" name="languages[${index}][spoken]" value="1" class="form-check-input">
                            <label class="form-check-label">Oui</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label d-block">Écrite</label>
                        <div class="form-check">
                            <input type="checkbox" name="languages[${index}][written]" value="1" class="form-check-input">
                            <label class="form-check-label">Oui</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger remove-language w-100">
                            Supprimer
                        </button>
                    </div>
                </div>
            `;

            wrapper.insertAdjacentHTML('beforeend', newRow);
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-language')) {
                e.target.closest('.language-row').remove();
            }
        });
    });
</script>