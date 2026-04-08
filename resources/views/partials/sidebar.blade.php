<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ Auth::user()->name }}</div> 
        
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.believers.statistics') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>ADMINISTRATION</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestion des Fidèles
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user"></i>
            <span>Fidèles</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Fidèles</h6>
                <a class="collapse-item" href="{{ route('admin.believers.statistics') }}">Vue Statistique</a>
                <a class="collapse-item" href="{{ route('admin.believers.index') }}">Liste des fidèles</a>
                <a class="collapse-item" href="{{ route('admin.believers.sanctions') }}">Sanction disciplinaire</a>
                <a class="collapse-item" href="{{ route('admin.believers.departures') }}">Fidèles ayant quitté</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Heading -->
    <div class="sidebar-heading">
        Registre
    </div>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#regitreMariage"
            aria-expanded="true" aria-controls="regitreMariage">
            <i class="fas fa-ring"></i>
            <span>Nos Registres</span>
        </a>
        <div id="regitreMariage" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Registres</h6>
                <a class="collapse-item" href="{{ route('admin.mariages.index') }}">Mariage</a>
                <a class="collapse-item" href="{{ route('admin.child_dedications.index') }}">Présentation d'enfant</a>
                <a class="collapse-item" href="{{ route('admin.funerals.index') }}">Funérailles</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Heading -->
    <div class="sidebar-heading">
        Gestion des Groupes
    </div>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#louange"
            aria-expanded="true" aria-controls="louange">
            <i class="fas fa-ring"></i>
            <span>Gestion des Groupes</span>
        </a>
        <div id="louange" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Registres</h6>
                <a class="collapse-item" href="{{ route('admin.groups.index') }}">Liste des groupes</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Heading -->
    <div class="sidebar-heading">
        Gestion des Rôles
    </div>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rolePermission"
            aria-expanded="true" aria-controls="rolePermission">
            <i class="fas fa-user-shield"></i>
            <span>Rôles et Permissions</span>
        </a>
        <div id="rolePermission" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin</h6>
                <a class="collapse-item" href="{{ route('admin.roles.index') }}">Rôles</a>
                <a class="collapse-item" href="{{ route('admin.users.index') }}">Liste des administrateurs</a>
                <a class="collapse-item" href="{{ route('admin.login.histories') }}">Le journal</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

        <!-- Heading -->
    <div class="sidebar-heading">
        Informations de l'église
    </div>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#infos"
            aria-expanded="true" aria-controls="infos">
            <i class="fas fa-user-shield"></i>
            <span>Informations</span>
        </a>
        <div id="infos" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Informations</h6>
                <a class="collapse-item" href="{{ route('admin.church_info.index') }}">Informations</a>
            </div>
        </div>
    </li>

</ul>
<!-- End of Sidebar -->