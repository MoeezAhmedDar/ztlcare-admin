<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'SB Admin') }} <sup>2</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Management</div>

    <li class="nav-item {{ request()->routeIs('admin.job-applications.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.job-applications.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Job Applications</span>
        </a>
    </li>

     <li class="nav-item {{ request()->routeIs('invite.portal') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('invite.portal')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Invite Letter</span>
        </a>
    </li>

    <!-- Interviews -->
    <li class="nav-item {{ request()->routeIs('interviews.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('interviews.index') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Interviews</span>
        </a>
    </li>

    <!-- Job Applications -->

    <li class="nav-item {{ request()->routeIs('offer.portal') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('offer.portal')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Offer Letter</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('rejection.portal') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rejection.portal')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Rejection Letter</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('character.portal') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('character.portal')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Character Certificate</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('reference.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reference.index')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Reference Request</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('custom_letters.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('custom_letters.index')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Custom Letter</span>
        </a>
    </li>

    <!-- <li class="nav-item {{ request()->routeIs('documents.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('documents.index')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Hr Documents</span>
        </a>
    </li> -->

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Configuration</div>

    <!-- Questionnaire -->
    <li class="nav-item {{ request()->routeIs('questionnaire.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('questionnaire.sections') }}">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>Questionnaire</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>Users</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>