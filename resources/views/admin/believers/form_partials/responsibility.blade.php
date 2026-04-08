<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Responsabilité à l'église</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{-- Responsabilité antérieure --}}
                <div class="form-group mb-3">
                    <label for="old" class="form-label" style="color: #000;">Responsabilité antérieure</label>
                    <input type="text" name="responsibility[old]" id="old" 
                            class="form-control @error('responsibility.old') is-invalid @enderror"
                            value="{{ old('responsibility.old', $believer->responsibility->old ?? '') }}">
                    @error('responsibility.old')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                {{-- Responsabilité actuelle --}}
                <div class="form-group mb-3">
                    <label for="current" class="form-label" style="color: #000;">Responsabilité actuelle</label>
                    <input type="text" name="responsibility[current]" id="current" 
                            class="form-control @error('responsibility.current') is-invalid @enderror"
                            value="{{ old('responsibility.current', $believer->responsibility->current ?? '') }}">
                    @error('responsibility.current')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                {{-- Responsabilité/groupe souhaité --}}
                <div class="form-group mb-3">
                    <label for="desired" class="form-label" style="color: #000;">Responsabilité/groupe souhaité</label>
                    <input type="text" name="responsibility[desired]" id="desired" 
                            class="form-control @error('responsibility.desired') is-invalid @enderror"
                            value="{{ old('responsibility.desired', $believer->responsibility->desired ?? '') }}">
                    @error('responsibility.desired')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div> 
</div>