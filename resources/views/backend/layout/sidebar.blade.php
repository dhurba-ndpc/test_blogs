    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

         <li class="nav-item">
            <a class="nav-link" href="{{ route('blog.index') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Blogs</span></a>
        </li>
         <li class="nav-item">
            <a class="nav-link" href="{{ route('blog.create') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Create Blog</span></a>
        </li>

    </ul>
