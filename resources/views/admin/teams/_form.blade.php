<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nom de l’équipe <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $team->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Objectif</label>
        <input type="text" name="objectif" class="form-control @error('objectif') is-invalid @enderror"
               value="{{ old('objectif', $team->objectif ?? '') }}">
        @error('objectif')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $team->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                {{ old('is_active', $team->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Équipe active</label>
        </div>
    </div>
</div>