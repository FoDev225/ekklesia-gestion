<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Informations Générales</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{-- NOM --}}
                <div class="form-group mb-3">
                    <label for="lastname" class="form-label" style="color: #000;">Nom <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" id="lastname" 
                            class="form-control @error('lastname') is-invalid @enderror"
                            value="{{ old('lastname', $believer->lastname ?? '') }}">
                    @error('lastname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                {{-- PRÉNOM --}}
                <div class="form-group mb-3">
                    <label for="firstname" class="form-label" style="color: #000;">Prénom(s) <span class="text-danger">*</span></label>
                    <input type="text" name="firstname" id="firstname" class="form-control @error('firstname') is-invalid @enderror"
                            value="{{ old('firstname', $believer->firstname ?? '') }}">
                    @error('firstname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                {{-- CIVILITÉ --}}
                <div class="form-group mb-3">
                    <label for="gender" class="form-label" style="color: #000;">Sexe <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach(App\Models\Believer::genders() as $c)
                            <option value="{{ $c }}" {{ old('gender', $believer->gender ?? '') == $c ? 'selected' : '' }}>
                                {{ $c }}
                            </option>
                        @endforeach
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
        </div>

        <div class="row">

            <div class="col-md-4">
                {{-- DATE DE NAISSANCE --}}
                <div class="form-group mb-3">
                    <label for="birth_date" class="form-label" style="color: #000;">Date de naissance <span class="text-danger">*</span></label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control"
                    value="{{ old('birth_date', $believer->birth_date?->format('Y-m-d')) }}">
                </div>
            </div>
            
            <div class="col-md-4">
                {{-- Ville de naissance --}}
                <div class="form-group mb-3">
                    <label for="birth_place" class="form-label" style="color: #000;">Ville de naissance <span class="text-danger">*</span></label>
                    <input type="text" name="birth_place" id="birth_place" class="form-control @error('birth_place') is-invalid @enderror"
                            value="{{ old('birth_place', $believer->birth_place ?? '') }}">
                    @error('birth_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                {{-- Nationalité --}}
                <div class="form-group mb-3">
                    <label for="nationality" class="form-label" style="color: #000;">Nationalité <span class="text-danger">*</span></label>
                    <input type="text" name="nationality" id="nationality" class="form-control @error('nationality') is-invalid @enderror"
                            value="{{ old('nationality', $believer->nationality ?? '') }}">
                    @error('nationality')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-4">
                {{-- Ethnie --}}
                <label for="ethnicity" class="form-label" style="color: #000;">Ethnie <span class="text-danger">*</span></label>
                <input type="text" name="ethnicity" id="ethnicity"
                    class="form-control @error('ethnicity') is-invalid @enderror"
                    value="{{ old('ethnicity', $believer->ethnicity ?? '') }}">
                @error('ethnicity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                {{-- Nombre d'enfants --}}
                <div class="form-group mb-3">
                    <label for="number_of_children" class="form-label" style="color: #000;">Nombre d'enfants</label>
                    <input type="number" name="number_of_children" id="number_of_children" class="form-control @error('number_of_children') is-invalid @enderror"
                            value="{{ old('number_of_children', $believer->number_of_children ?? '') }}">
                    @error('number_of_children')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                {{-- Numéro Carte Nationale d'Identité --}}
                <div class="form-group mb-3">
                    <label for="cni_number" class="form-label" style="color: #000;">N° CNI/PC/ATT/PASS/SEJOUR </label>
                    <input type="text" name="cni_number" id="cni_number" class="form-control @error('cni_number') is-invalid @enderror"
                            value="{{ old('cni_number', $believer->cni_number ?? '') }}">
                    @error('cni_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>