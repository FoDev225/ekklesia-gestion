<div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-danger text-primary text-uppercase">
                <strong>Adresse & Contact</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        {{-- Numéro WhatsApp --}}
                        <div class="form-group mb-3">
                            <label for="whatsapp_number" class="form-label" style="color: #000;">Numéro WhatsApp</label>
                            <input type="text" name="address[whatsapp_number]" id="whatsapp_number"
                                class="form-control @error('address.whatsapp_number') is-invalid @enderror"
                                value="{{ old('address.whatsapp_number', $believer->address->whatsapp_number ?? '') }}">
                            @error('address.whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Numéro de Téléphone --}}
                        <div class="form-group mb-3">
                            <label for="phone_number" class="form-label" style="color: #000;">Autre numéro de téléphone </label>
                            <input type="text" name="address[phone_number]" id="phone_number" 
                                    class="form-control @error('address.phone_number') is-invalid @enderror"
                                    value="{{ old('address.phone_number', $believer->address->phone_number ?? '') }}">
                            @error('address.phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Adresse Mail --}}
                        <div class="form-group mb-3">
                            <label for="email" class="form-label" style="color: #000;">Adresse email </label>
                            <input type="email" name="address[email]" id="email" 
                                    class="form-control @error('address.email') is-invalid @enderror"
                                    value="{{ old('address.email', $believer->address->email ?? '') }}">
                            @error('address.email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        {{-- Commune --}}
                        <div class="form-group mb-3">
                            <label for="commune" class="form-label" style="color: #000;">Commune </label>
                            <input type="text" name="address[commune]" id="commune" 
                                    class="form-control @error('address.commune') is-invalid @enderror"
                                    value="{{ old('address.commune', $believer->address->commune ?? '') }}">
                            @error('address.commune')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Quartier --}}
                        <div class="form-group mb-3">
                            <label for="quartier" class="form-label" style="color: #000;">Quartier </label>
                            <input type="text" name="address[quartier]" id="quartier" 
                                    class="form-control @error('address.quartier') is-invalid @enderror"
                                    value="{{ old('address.quartier', $believer->address->quartier ?? '') }}">
                            @error('address.quartier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Sous-quartier --}}
                        <div class="form-group mb-3">
                            <label for="sous_quartier" class="form-label" style="color: #000;">Sous-quartier </label>
                            <input type="text" name="address[sous_quartier]" id="sous_quartier" 
                                    class="form-control @error('address.sous_quartier') is-invalid @enderror"
                                    value="{{ old('address.sous_quartier', $believer->address->sous_quartier ?? '') }}">
                            @error('address.sous_quartier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div> 
        </div>