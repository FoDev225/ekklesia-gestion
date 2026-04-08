<div class="card mb-4 shadow-sm border-primary">
    <div class="card-header bg-outline-danger text-primary text-uppercase">
        <strong>Baptème</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                {{-- Connaissance à l'église --}}
                <div class="form-group mb-3">
                    <label for="connaissance_eglise" class="form-label" style="color: #000;">Autre connaissance à l'église</label>
                    <input type="text" name="church_information[connaissance_eglise]" id="connaissance_eglise" 
                        class="form-control @error('church_information.connaissance_eglise') is-invalid @enderror"
                        value="{{ old('church_information.connaissance_eglise', $believer->churchInformation->connaissance_eglise ?? '') }}">
                       
                        @error('church_information.connaissance_eglise')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror     
                </div>
            </div>

            <div class="col-md-4">
                {{-- Eglise d'origine --}}
                <div class="form-group mb-3">
                    <label for="original_church" class="form-label" style="color: #000;">Eglise d'origine</label>
                    <input type="text" name="church_information[original_church]" id="original_church" 
                        class="form-control @error('church_information.original_church') is-invalid @enderror"
                        value="{{ old('church_information.original_church', $believer->churchInformation->original_church ?? '') }}">
                        
                        @error('church_information.original_church')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror   
                </div>
            </div>

            <div class="col-md-4">
                {{-- Année d'arrivée --}}
                <div class="form-group mb-3">
                    <label for="arrival_year" class="form-label" style="color: #000;">Année d'arrivée</label>
                    <input type="text" name="church_information[arrival_year]" id="arrival_year" 
                    class="form-control @error('church_information.arrival_year') is-invalid @enderror"
                    value="{{ old('church_information.arrival_year', $believer->churchInformation->arrival_year ?? '') }}">
                            
                    @error('church_information.arrival_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                {{-- DATE DE CONVERSION --}}
                <div class="form-group mb-3">
                    <label for="conversion_date" class="form-label" style="color: #000;">Date de conversion</label>
                    <input type="date" name="church_information[conversion_date]" id="conversion_date" 
                    class="form-control @error('church_information.conversion_date') is-invalid @enderror"
                    value="{{ old('church_information.conversion_date', $believer->churchInformation?->conversion_date?->format('Y-m-d')) }}">
                            
                    @error('church_information.conversion_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                    {{-- LIEU DE CONVERSION --}}
                <div class="form-group mb-3">
                    <label for="conversion_place" class="form-label" style="color: #000;">Lieu de conversion</label>
                    <input type="text" name="church_information[conversion_place]" id="conversion_place" 
                    class="form-control @error('church_information.conversion_place') is-invalid @enderror"
                    value="{{ old('church_information.conversion_place', $believer->churchInformation->conversion_place ?? '') }}">
                    
                    @error('church_information.conversion_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                {{-- BAPTISÉ --}}
                <div class="form-group mb-3">
                    <label for="baptised" class="form-label" style="color: #000;">Baptisé(e) ? <span class="text-danger">*</span></label>
                    <select name="church_information[baptised]" id="baptised" class="form-control @error('church_information.baptised') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach(App\Models\ChurchInformation::baptismStatus() as $b)
                            <option value="{{ $b }}" {{ old('church_information.baptised', $believer->churchInformation->baptised ?? '') == $b ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                    
                    @error('church_information.baptised')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                {{-- DATE DE BAPTEME --}}
                <div class="form-group mb-3">
                    <label for="baptism_date" class="form-label" style="color: #000;">Date du baptême</label>
                    <input type="date" name="church_information[baptism_date]" id="baptism_date" 
                    class="form-control @error('church_information.baptism_date') is-invalid @enderror"
                    value="{{ old('church_information.baptism_date', $believer->churchInformation?->baptism_date?->format('Y-m-d')) }}">
                            
                    @error('church_information.baptism_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-3">
                    {{-- LIEU DU BAPTÊME --}}
                <div class="form-group mb-3">
                    <label for="baptism_place" class="form-label" style="color: #000;">Lieu du baptême</label>
                    <input type="text" name="church_information[baptism_place]" id="baptism_place" 
                        class="form-control @error('church_information.baptism_place') is-invalid @enderror"
                        value="{{ old('church_information.baptism_place', $believer->churchInformation->baptism_place ?? '') }}">
                        
                        @error('church_information.baptism_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>

            <div class="col-md-3">
                    {{-- PASTEUR DU BAPTÊME --}}
                <div class="form-group mb-3">
                    <label for="baptism_pastor" class="form-label" style="color: #000;">Pasteur officiant le baptême</label>
                    <input type="text" name="church_information[baptism_pastor]" id="baptism_pastor" 
                        class="form-control @error('church_information.baptism_pastor') is-invalid @enderror"
                        value="{{ old('church_information.baptism_pastor', $believer->churchInformation->baptism_pastor ?? '') }}">
                        
                        @error('church_information.baptism_pastor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>

            <div class="col-md-3">
                {{-- Numéro carte de baptême --}}
                <div class="form-group mb-3">
                    <label for="baptism_card_number" class="form-label" style="color: #000;">N° carte de baptême</label>
                    <input type="text" name="church_information[baptism_card_number]" id="baptism_card_number" 
                        class="form-control @error('church_information.baptism_card_number') is-invalid @enderror"
                        value="{{ old('church_information.baptism_card_number', $believer->churchInformation->baptism_card_number ?? '') }}">
                        
                        @error('church_information.baptism_card_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>

            <div class="col-md-3">
                {{-- Numéro carte de membre --}}
                <div class="form-group mb-3">
                    <label for="membership_card_number" class="form-label" style="color: #000;">N° carte de membre (AEBECI)</label>
                    <input type="text" name="church_information[membership_card_number]" id="membership_card_number" 
                        class="form-control @error('church_information.membership_card_number') is-invalid @enderror"
                        value="{{ old('church_information.membership_card_number', $believer->churchInformation->membership_card_number ?? '') }}">
                        
                        @error('church_information.membership_card_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>

        </div>
    </div> 
</div>