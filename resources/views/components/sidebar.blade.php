<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img src="../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Project Management</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                           Team
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        @can('user.view')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Team List</p>
                            </a>
                        </li> 
                        @endcan
                        @can('role.view')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-item">
                  <a href="{{ route('clients.index') }}" class="nav-link">
                      <i class="nav-icon bi bi-grip-horizontal"></i>
                      <p>Client</p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('projects.index') }}" class="nav-link">
                    <i class="nav-icon bi bi-grip-horizontal"></i>
                    <p>Project</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tasks.all') }}" class="nav-link">
                    <i class="nav-icon bi bi-grip-horizontal"></i>
                    <p>Task</p>
                </a>
            </li>
                
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
