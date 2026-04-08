<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Situation Matrimoniale</strong>
    </div>
    <div class="card-body">
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="marital_status" class="form-label" style="color: #000;">Situation maritale <span class="text-danger">*</span></label>
                    <select name="marital_status" id="marital_status" class="form-control @error('marital_status') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach(App\Models\Believer::maritalStatus() as $s)
                            <option value="{{ $s }}" {{ old('marital_status', $believer->marital_status ?? '') == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                    @error('marital_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                {{-- DATE DE NAISSANCE --}}
                <div class="form-group mb-3">
                    <label for="marriage_date" class="form-label" style="color: #000;">Date du mariage</label>
                    <input type="date" name="marriage_date" id="marriage_date" class="form-control @error('marriage_date') is-invalid @enderror"
                    value="{{ old('marriage_date', $believer->marriage_date?->format('Y-m-d')) }}">
                    @error('marriage_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                {{-- Nom du conjoint --}}
                <div class="form-group mb-3">
                    <label for="spouse_name" class="form-label" style="color: #000;">Nom du conjoint</label>
                    <input type="text" name="spouse_name" id="spouse_name" class="form-control @error('spouse_name') is-invalid @enderror"
                    value="{{ old('spouse_name', $believer->spouse_name ?? '') }}">
                    @error('spouse_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>