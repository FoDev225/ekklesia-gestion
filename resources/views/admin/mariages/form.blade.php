
@extends('layouts.app')

@section('title', $mariage->exists ? 'Modifier la fiche de ' . $mariage->groom->firstname . ' ' . $mariage->groom->lastname : 'Ajouter une fiche mariage')

@section('content')

<div class="container-fluid">
    <h2 class="mb-0 text-uppercase">@yield('title')</h2>
    <hr class="sidebar-divider my-3">

    <div class="alert alert-warning" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
    </div>

    {{-- ========== FORMULAIRE D'ENREGISTREMENT / MODIFICATION ========== --}}

    <form action="{{ $mariage->exists ? route('admin.mariages.update', $mariage->id) : route('admin.mariages.store') }}" 
        method="POST" enctype="multipart/form-data">
        @csrf
        @if($mariage->exists)
            @method('PUT')
        @endif
    
        {{-- ====================== LE FIANCE ====================== --}}
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-outline-primary text-primary text-uppercase">
                <strong>Le fiancé</strong>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="form-check col-md-6 mb-3">
                        <input class="form-check-input" type="checkbox" id="groom_is_member" name="groom_is_member" value="1">
                        <label class="form-check-label" for="groom_is_member" style="color: #000;">Le fiancé est membre de l’église</label>
                    </div>
                    <div id="groom_member_fields">
                        <div class="form-check col-md-12 mb-3">
                            <label style="color: #000;">Sélectionner le fiancé</label>
                            <select name="groom_id" id="groom_id" class="form-control">
                                <option value="">-- Sélectionner --</option>
                                @foreach(\App\Models\Believer::where('marital_status', 'Célibataire')->where('gender', 'Masculin')->get() as $believer)
                                    <option value="{{ $believer->id }}">
                                        {{ $believer->lastname }} {{ $believer->firstname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="groom_photo" class="form-label" style="color: #000;">Photo <span class="text-danger">*</span></label>
                            <input type="file" name="groom_photo" id="groom_photo" class="form-control @error('groom_photo') is-invalid @enderror"
                                accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                            @error('groom_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div id="groom_manual_fields" style="display:none">
                    <div class="row groom_manual_fields">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="groom_name" class="form-label" style="color: #000;">Nom & Prénoms <span class="text-danger">*</span></label>
                                <input type="text" name="groom_name" id="groom_name" class="form-control @error('groom_name') is-invalid @enderror"
                                        value="{{ old('groom_name', $mariage->groom_name ?? '') }}">
                                @error('groom_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="groom_birthdate" class="form-label" style="color: #000;">Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" name="groom_birthdate" id="groom_birthdate" class="form-control @error('groom_birthdate') is-invalid @enderror"
                                        value="{{ old('groom_birthdate', $mariage->groom_birthdate ?? '') }}">
                                @error('groom_birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="groom_birth_place" class="form-label" style="color: #000;">Lieu de naissance <span class="text-danger">*</span></label>
                                <input type="text" name="groom_birth_place" id="groom_birth_place" class="form-control @error('groom_birth_place') is-invalid @enderror"
                                        value="{{ old('groom_birth_place', $mariage->groom_birth_place ?? '') }}">
                                @error('groom_birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="groom_bapistism_date" class="form-label" style="color: #000;">Date de baptême <span class="text-danger">*</span></label>
                                <input type="date" name="groom_bapistism_date" id="groom_bapistism_date" class="form-control @error('groom_bapistism_date') is-invalid @enderror"
                                        value="{{ old('groom_bapistism_date', $mariage->groom_bapistism_date ?? '') }}">
                                @error('groom_bapistism_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row groom_manual_fields">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="groom_bapistism_place" class="form-label" style="color: #000;">Lieu du baptême <span class="text-danger">*</span></label>
                                <input type="text" name="groom_bapistism_place" id="groom_bapistism_place" class="form-control @error('groom_bapistism_place') is-invalid @enderror"
                                        value="{{ old('groom_bapistism_place', $mariage->groom_bapistism_place ?? '') }}">
                                @error('groom_bapistism_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="baptism_officer_groom" class="form-label" style="color: #000;">Baptisé par <span class="text-danger">*</span></label>
                                <input type="text" name="baptism_officer_groom" id="baptism_officer_groom" class="form-control @error('baptism_officer_groom') is-invalid @enderror"
                                        value="{{ old('baptism_officer_groom', $mariage->baptism_officer_groom ?? '') }}">
                                @error('baptism_officer_groom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="groom_profession" class="form-label" style="color: #000;">Profession <span class="text-danger">*</span></label>
                                <input type="text" name="groom_profession" id="groom_profession" class="form-control @error('groom_profession') is-invalid @enderror"
                                        value="{{ old('groom_profession', $mariage->groom_profession ?? '') }}">
                                @error('groom_profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================== LA FIANCEE ====================== --}}
        <div class="card mb-4 shadow-sm border-info">
            <div class="card-header bg-outline-info text-info text-uppercase">
                <strong>La fiancée</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-check col-md-6 mb-3">
                        <input class="form-check-input" type="checkbox" id="bride_is_member" name="bride_is_member" value="1">
                        <label class="form-check-label" for="bride_is_member" style="color: #000;">La fiancée est membre de l’église</label>
                    </div>
                    <div id="bride_member_fields">
                        <div class="form-check col-md-12 mb-3">
                            <label style="color: #000;">Sélectionner la fiancée</label>
                            <select name="bride_id" id="bride_id" class="form-control">
                                <option value="">-- Sélectionner --</option>
                                @foreach(\App\Models\Believer::where('marital_status', 'Célibataire')->where('gender', 'Féminin')->get() as $believer)
                                    <option value="{{ $believer->id }}">
                                        {{ $believer->lastname }} {{ $believer->firstname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <label for="bride_photo" class="form-label" style="color: #000;">Photo <span class="text-danger">*</span></label>
                            <input type="file" name="bride_photo" id="bride_photo" class="form-control @error('bride_photo') is-invalid @enderror"
                                accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                            @error('bride_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            
                <div id="bride_manual_fields" style="display:none">
                    <div class="row bride_manual_fields">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="bride_name" class="form-label" style="color: #000;">Nom & Prénoms <span class="text-danger">*</span></label>
                                <input type="text" name="bride_name" id="bride_name" class="form-control @error('bride_name') is-invalid @enderror"
                                        value="{{ old('bride_name', $mariage->bride_name ?? '') }}">
                                @error('bride_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="bride_birthdate" class="form-label" style="color: #000;">Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" name="bride_birthdate" id="bride_birthdate" class="form-control @error('bride_birthdate') is-invalid @enderror"
                                        value="{{ old('bride_birthdate', $mariage->bride_birthdate ?? '') }}">
                                @error('bride_birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="bride_birth_place" class="form-label" style="color: #000;">Lieu de naissance <span class="text-danger">*</span></label>
                                <input type="text" name="bride_birth_place" id="bride_birth_place" class="form-control @error('bride_birth_place') is-invalid @enderror"
                                        value="{{ old('bride_birth_place', $mariage->bride_birth_place ?? '') }}">
                                @error('bride_birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="bride_bapistism_date" class="form-label" style="color: #000;">Date de baptême <span class="text-danger">*</span></label>
                                <input type="date" name="bride_bapistism_date" id="bride_bapistism_date" class="form-control @error('bride_bapistism_date') is-invalid @enderror"
                                        value="{{ old('bride_bapistism_date', $mariage->bride_bapistism_date ?? '') }}">
                                @error('bride_bapistism_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row bride_manual_fields">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="bride_bapistism_place" class="form-label" style="color: #000;">Lieu du baptême <span class="text-danger">*</span></label>
                                <input type="text" name="bride_bapistism_place" id="bride_bapistism_place" class="form-control @error('bride_bapistism_place') is-invalid @enderror"
                                        value="{{ old('bride_bapistism_place', $mariage->bride_bapistism_place ?? '') }}">
                                @error('bride_bapistism_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="baptism_officer_bride" class="form-label" style="color: #000;">Baptisé par <span class="text-danger">*</span></label>
                                <input type="text" name="baptism_officer_bride" id="baptism_officer_bride" class="form-control @error('baptism_officer_bride') is-invalid @enderror"
                                        value="{{ old('baptism_officer_bride', $mariage->baptism_officer_bride ?? '') }}">
                                @error('baptism_officer_bride')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="bride_profession" class="form-label" style="color: #000;">Profession <span class="text-danger">*</span></label>
                                <input type="text" name="bride_profession" id="bride_profession" class="form-control @error('bride_profession') is-invalid @enderror"
                                        value="{{ old('bride_profession', $mariage->bride_profession ?? '') }}">
                                @error('bride_profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================== MARIAGE CIVIL ====================== --}}
        <div class="card mb-4 shadow-sm border-warning">
            <div class="card-header bg-outline-warning text-warning text-uppercase">
                <strong>Mariage Civil</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="civil_marriage_date" class="form-label" style="color: #000;">Date <span class="text-danger">*</span></label>
                            <input type="date" name="civil_marriage_date" id="civil_marriage_date" class="form-control @error('civil_marriage_date') is-invalid @enderror"
                                    value="{{ old('civil_marriage_date', $mariage->civil_marriage_date ?? '') }}">
                            @error('civil_marriage_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="civil_marriage_place" class="form-label" style="color: #000;">Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="civil_marriage_place" id="civil_marriage_place" class="form-control @error('civil_marriage_place') is-invalid @enderror"
                                    value="{{ old('civil_marriage_place', $mariage->civil_marriage_place ?? '') }}">
                            @error('civil_marriage_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================== MARIAGE RELIGIEUX ====================== --}}
        <div class="card mb-4 shadow-sm border-success">
            <div class="card-header bg-outline-success text-success text-uppercase">
                <strong>Mariage religieux</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="religious_marriage_date" class="form-label" style="color: #000;">Date <span class="text-danger">*</span></label>
                            <input type="date" name="religious_marriage_date" id="religious_marriage_date" class="form-control @error('religious_marriage_date') is-invalid @enderror"
                                    value="{{ old('religious_marriage_date', $mariage->religious_marriage_date ?? '') }}">
                            @error('religious_marriage_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="religious_marriage_place" class="form-label" style="color: #000;">Lieu <span class="text-danger">*</span></label>
                            <input type="text" name="religious_marriage_place" id="religious_marriage_place" class="form-control @error('religious_marriage_place') is-invalid @enderror"
                                    value="{{ old('religious_marriage_place', $mariage->religious_marriage_place ?? '') }}">
                            @error('religious_marriage_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="wedding_mc" class="form-label" style="color: #000;">Maître de cérémonie <span class="text-danger">*</span></label>
                            <input type="text" name="wedding_mc" id="wedding_mc" class="form-control @error('wedding_mc') is-invalid @enderror"
                                    value="{{ old('wedding_mc', $mariage->wedding_mc ?? '') }}">
                            @error('wedding_mc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="wedding_preacher" class="form-label" style="color: #000;">Prédicateur <span class="text-danger">*</span></label>
                            <input type="text" name="wedding_preacher" id="wedding_preacher" class="form-control @error('wedding_preacher') is-invalid @enderror"
                                    value="{{ old('wedding_preacher', $mariage->wedding_preacher ?? '') }}">
                            @error('wedding_preacher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="officiant" class="form-label" style="color: #000;">Officiant <span class="text-danger">*</span></label>
                            <input type="text" name="officiant" id="officiant" class="form-control @error('officiant') is-invalid @enderror"
                                    value="{{ old('officiant', $mariage->officiant ?? '') }}">
                            @error('officiant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="hand_bible" class="form-label" style="color: #000;">Remise de la Bible <span class="text-danger">*</span></label>
                            <input type="text" name="hand_bible" id="hand_bible" class="form-control @error('hand_bible') is-invalid @enderror"
                                    value="{{ old('hand_bible', $mariage->hand_bible ?? '') }}">
                            @error('hand_bible')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ====================== MARIAGE RELIGIEUX ====================== --}}
        <div class="card mb-4 shadow-sm border-secondary">
            <div class="card-header bg-outline-secondary text-secondary text-uppercase">
                <strong>Témoins</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="groom_witness" class="form-label" style="color: #000;">Témoin du marié <span class="text-danger">*</span></label>
                            <input type="text" name="groom_witness" id="groom_witness" class="form-control @error('groom_witness') is-invalid @enderror"
                                    value="{{ old('groom_witness', $mariage->groom_witness ?? '') }}">
                            @error('groom_witness')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="groom_witness_profession" class="form-label" style="color: #000;">Profession <span class="text-danger">*</span></label>
                            <input type="text" name="groom_witness_profession" id="groom_witness_profession" class="form-control @error('groom_witness_profession') is-invalid @enderror"
                                    value="{{ old('groom_witness_profession', $mariage->groom_witness_profession ?? '') }}">
                            @error('groom_witness_profession')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="bride_witness" class="form-label" style="color: #000;">Témoin de la mariée <span class="text-danger">*</span></label>
                            <input type="text" name="bride_witness" id="bride_witness" class="form-control @error('bride_witness') is-invalid @enderror"
                                    value="{{ old('bride_witness', $mariage->bride_witness ?? '') }}">
                            @error('bride_witness')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="bride_witness_profession" class="form-label" style="color: #000;">Profession <span class="text-danger">*</span></label>
                            <input type="text" name="bride_witness_profession" id="bride_witness_profession" class="form-control @error('bride_witness_profession') is-invalid @enderror"
                                    value="{{ old('bride_witness_profession', $mariage->bride_witness_profession ?? '') }}">
                            @error('bride_witness_profession')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
        {{-- ====================== BOUTONS ====================== --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">
                {{ $mariage->exists ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
            <a href="{{ route('admin.mariages.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
  
      
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        function toggleFields(checkboxId, memberFieldsId, manualFieldsId) {
            const checkbox = document.getElementById(checkboxId);
            const memberFields = document.getElementById(memberFieldsId);
            const manualFields = document.getElementById(manualFieldsId);

            if (!checkbox) return;

            function toggle() {
                if (checkbox.checked) {
                    memberFields.style.display = 'block';
                    manualFields.style.display = 'none';
                } else {
                    memberFields.style.display = 'none';
                    manualFields.style.display = 'block';
                }
            }

            // 🔹 état initial
            toggle();

            // 🔹 écouteur
            checkbox.addEventListener('change', toggle);
        }

        // Groom
        toggleFields(
            'groom_is_member',
            'groom_member_fields',
            'groom_manual_fields'
        );

        // Bride
        toggleFields(
            'bride_is_member',
            'bride_member_fields',
            'bride_manual_fields'
        );
    });
</script>

@endsection