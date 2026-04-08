<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Profession</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                {{-- Profession --}}
                <div class="form-group mb-3">
                    <label for="profession" class="form-label" style="color: #000;">Profession</label>
                    <input type="text" name="profession[profession]" id="profession" 
                            class="form-control @error('profession.profession') is-invalid @enderror"
                            value="{{ old('profession.profession', $believer->profession->profession ?? '') }}">
                    @error('profession.profession')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                {{-- Fonction --}}
                <div class="form-group mb-3">
                    <label for="fonction" class="form-label" style="color: #000;">Fonction</label>
                    <input type="text" name="profession[fonction]" id="fonction" 
                            class="form-control @error('profession.fonction') is-invalid @enderror"
                            value="{{ old('profession.fonction', $believer->profession->fonction ?? '') }}">
                    @error('profession.fonction')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {{-- Entreprise/Service --}}
                <div class="form-group mb-3">
                    <label for="company" class="form-label" style="color: #000;">Entreprise/Service</label>
                    <input type="text" name="profession[company]" id="company" 
                            class="form-control @error('profession.company') is-invalid @enderror"
                            value="{{ old('profession.company', $believer->profession->company ?? '') }}">
                    @error('profession.company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                {{-- Contact professionnel --}}
                <div class="form-group mb-3">
                    <label for="professional_contact" class="form-label" style="color: #000;">Contact professionnel</label>
                    <input type="text" name="profession[professional_contact]" id="professional_contact" 
                            class="form-control @error('profession.professional_contact') is-invalid @enderror"
                            value="{{ old('profession.professional_contact', $believer->profession->professional_contact ?? '') }}">
                    @error('profession.professional_contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div> 
</div>