<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Formation & Diplôme</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{-- Niveau d'étude --}}
                <div class="form-group mb-3">
                    <label for="level_of_education" class="form-label" style="color: #000;">Niveau d'étude</label>
                    <input type="text" name="education[level_of_education]" id="level_of_education" 
                            class="form-control @error('education.level_of_education') is-invalid @enderror"
                            value="{{ old('education.level_of_education', $believer->education->level_of_education ?? '') }}">
                    @error('education.level_of_education')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                {{-- Diplôme --}}
                <div class="form-group mb-3">
                    <label for="degree" class="form-label" style="color: #000;">Diplôme</label>
                    <input type="text" name="education[degree]" id="degree" 
                            class="form-control @error('education.degree') is-invalid @enderror"
                            value="{{ old('education.degree', $believer->education->degree ?? '') }}">
                    @error('education.degree')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                {{-- Qualification --}}
                <div class="form-group mb-3">
                    <label for="qualification" class="form-label" style="color: #000;">Qualification</label>
                    <input type="text" name="education[qualification]" id="qualification" 
                            class="form-control @error('education.qualification') is-invalid @enderror"
                            value="{{ old('education.qualification', $believer->education->qualification ?? '') }}">
                    @error('education.qualification')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div> 
</div>