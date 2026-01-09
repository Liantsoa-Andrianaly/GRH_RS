<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Logo -->
    <div class="text-center my-3">
        <img src="{{ asset('/img/service.png') }}" alt="Logo" style="width: 150px; height:150px;">
    </div>
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span style="margin-left: 20px;">Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <!-- Section Employé -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee"
            aria-expanded="false" aria-controls="collapseEmployee">
            <i class="fas fa-user"></i>
            <span style="margin-left: 20px;">Employé</span>
        </a>
        <div id="collapseEmployee" class="collapse" aria-labelledby="headingEmployee" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('employees.create') }}">Ajouter un employé</a>
                <a class="collapse-item" href="{{ route('employees.index') }}">Liste des employés</a>
                <a class="collapse-item" href="{{ route('backups.index') }}">Backups</a>
                <hr>
                <a class="collapse-item" href="{{ route('agences.index') }}">Agences</a>
                <a class="collapse-item" href="{{ route('services.index') }}">Services</a>
                <a class="collapse-item" href="{{ route('postes.index') }}">Postes</a>
                <hr>
                <a class="collapse-item" href="{{ route('affectations.index') }}">Affectation des Employés</a>
            </div>
        </div>
    </li>

    <!-- Section Présence -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePresence"
            aria-expanded="false" aria-controls="collapsePresence">
            <i class="fas fa-clock"></i>
            <span style="margin-left: 20px;">Présence</span>
        </a>
        <div id="collapsePresence" class="collapse" aria-labelledby="headingPresence" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('pointages.index') }}">Pointage</a>
                <a class="collapse-item" href="{{ route('pointages.suivi') }}" >Suivi Présence</a>
            </div>
        </div>
    </li>

    <!-- Section Congés & Absences -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConge"
            aria-expanded="false" aria-controls="collapseConge">
            <i class="fas fa-calendar-alt"></i>
            <span style="margin-left: 20px;">Congés </span>
        </a>
        <div id="collapseConge" class="collapse" aria-labelledby="headingConge" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('conges.create') }}">Faire une demande</a>
                
                <a class="collapse-item" href="{{ route('conges.index') }}">Toutes les demandes</a>
            </div>
        </div>
    </li>

    <!-- Section Types de prélèvements >
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrelevement"
            aria-expanded="false" aria-controls="collapsePrelevement">
            <i class="fas fa-file-invoice-dollar"></i>
            <span style="margin-left: 20px;">Type de prélèvement</span>
        </a>
        <div id="collapsePrelevement" class="collapse" aria-labelledby="headingPrelevement" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('types_prelevements.create') }}">Ajouter un type</a>
                <a class="collapse-item" href="{{ route('types_prelevements.index') }}">Liste des types</a>
            </div>
        </div>
    </li-->



</ul>
