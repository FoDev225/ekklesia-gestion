<div class="container-fluid text-center">
    
    <h2 class="fw-bold text-uppercase text-primary">
        Système de Gestion de l’Église
    </h2>
    <p class="mb-5 text-center" style="color:#C9A635;font-size:1.1em;font-style:italic;">Organisés pour mieux servir Dieu</p>

    <div class="row mt-5">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-4 col-sm-4 col-6 mb-4">
            <div class="card shadow-lg h-100 py-2 hover-card">
                <div class="card-body">
                    {{-- <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div> --}}
                    <div>
                        <a href="{{ route('admin.believers.statistics') }}" class="btn btn-primary text-white py-3 btn-sm">
                            <span class="bi bi-person-fill fs-2"></span>
                            GESTION DES FIDELES
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-4 col-6 mb-4">
            <div class="card shadow-lg h-100 py-2 hover-card">
                <div class="card-body">
                    <div>
                        <a href="{{ route('admin.programs.index') }}" class="btn btn-success text-white py-3 btn-sm">
                            <span class="bi bi-building fs-2"></span>
                            GESTION DES CULTES
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-4 col-6 mb-4">
            <div class="card shadow-lg h-100 py-2 hover-card">
                <div class="card-body">
                    <div>
                        <a href="" class="btn btn-info text-white py-3 btn-sm">
                            <span class="bi bi-calendar-event fs-2"></span> 
                            GESTION DES ACTIVITES
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-4 col-6 mb-4">
            <div class="card shadow-lg h-100 py-2 hover-card">
                <div class="card-body">
                    <div>
                        <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary text-white py-3 btn-sm">
                            <span class="bi bi-people fs-2"></span>
                            GESTION DES EQUIPES
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-4 col-6 mb-4">
            <div class="card shadow-lg h-100 py-2 hover-card">
                <div class="card-body">
                    <div>
                        <a href="" class="btn btn-warning text-white py-3 btn-sm">
                            <span class="bi bi-cash-stack fs-2"></span>
                            GESTION DES FINANCES
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Petite animation au survol --}}
<style>
    .hover-card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease-in-out;
    }

    .bg-purple {
    background-color: #6f42c1 !important; /* Violet Bootstrap officiel */
    }
    .bg-purple:hover {
        background-color: #5a32a3 !important; /* Teinte plus foncée au survol */
    }
</style>