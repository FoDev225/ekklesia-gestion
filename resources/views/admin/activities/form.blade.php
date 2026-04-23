<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">Titre de l’activité <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $activity->title ?? '') }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Thème</label>
        <input type="text" name="theme" class="form-control @error('theme') is-invalid @enderror"
            value="{{ old('theme', $activity->theme ?? '') }}">
        @error('theme')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Modérateur</label>
        <input type="text" name="moderator" class="form-control @error('moderator') is-invalid @enderror"
            value="{{ old('moderator', $activity->moderator ?? '') }}">
        @error('moderator')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Prédicateur</label>
        <input type="text" name="preacher" class="form-control @error('preacher') is-invalid @enderror"
            value="{{ old('preacher', $activity->preacher ?? '') }}">
        @error('preacher')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Date</label>
        <input type="date" name="scheduled_date" class="form-control @error('scheduled_date') is-invalid @enderror"
            value="{{ old('scheduled_date', isset($activity) && $activity->scheduled_date ? $activity->scheduled_date->format('Y-m-d') : '') }}">
        @error('scheduled_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Lieu</label>
        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
            value="{{ old('location', $activity->location ?? '') }}">
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Statut <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="scheduled" {{ old('status', $activity->status ?? '') == 'scheduled' ? 'selected' : '' }}>Prévu</option>
            <option value="completed" {{ old('status', $activity->status ?? '') == 'completed' ? 'selected' : '' }}>Terminé</option>
            <option value="canceled" {{ old('status', $activity->status ?? '') == 'canceled' ? 'selected' : '' }}>Annulé</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>