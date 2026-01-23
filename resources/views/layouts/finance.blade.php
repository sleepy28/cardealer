<nav class="sidebar">
    
    
    <div class="sidebar-brand d-flex align-items-center gap-3 px-4 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="position-relative d-flex align-items-center justify-content-center">
            <div class="position-absolute bg-primary rounded-circle" style="width: 25px; height: 25px; filter: blur(20px); opacity: 0.5; z-index: 0;"></div>
            
            <img src="{{ asset('img/logonusa.png') }}" alt="Nusa Logo" class="position-relative" style="height: 42px; width: auto; object-fit: contain; z-index: 1;">
        </div>
        <div class="d-flex flex-column justify-content-center">
            <h5 class="m-0 fw-bold text-white tracking-wide" style="letter-spacing: 1px;">NUSA</h5>
            <span class="text-uppercase fw-bold text-primary" style="font-size: 0.65rem; letter-spacing: 3px; margin-top: -2px; opacity: 0.9;">Car Dealer</span>
        </div>
    </div>

    
    <div class="nav-links nav-scroll flex-grow-1 px-2 mt-3" style="overflow-y: auto;">

        
        
        
        @if(Auth::user()->role === 'admin')
            
            <div class="px-3 mb-2 mt-2 text-uppercase fw-bold" style="font-size: 0.7rem; color: #64748b; letter-spacing: 0.5px;">Admin Menu</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-th-large fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Dashboard</span>
            </a>

            <a href="{{ route('leaderboard') }}" class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fa-solid fa-trophy fw-bold text-warning" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Leaderboard</span>
            </a>

            <a href="{{ route('admin.employees') }}" class="nav-link {{ request()->routeIs('admin.employees') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-users fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Employees</span>
            </a>
            
            <a href="{{ route('admin.permits.index') }}" class="nav-link {{ request()->routeIs('admin.permits.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-envelope-open-text fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Permit Approval</span>
            </a>

            <div class="px-3 mb-2 mt-4 text-uppercase fw-bold" style="font-size: 0.7rem; color: #64748b; letter-spacing: 0.5px;">Finance</div>

            <a href="{{ route('admin.salary.index') }}" class="nav-link {{ request()->routeIs('admin.salary.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fa-solid fa-hand-holding-dollar fw-bold text-success" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Payroll & Komisi</span>
            </a>

            <a href="{{ route('admin.commission.index') }}" class="nav-link {{ request()->routeIs('admin.commission.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fa-solid fa-tags fw-bold text-info" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Master Komisi</span>
            </a>

        
        
        
        @elseif(Auth::user()->role === 'finance')

            
            <div class="px-3 mb-2 mt-2 text-uppercase fw-bold" style="font-size: 0.7rem; color: #64748b; letter-spacing: 0.5px;">Main Menu</div>

            
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-tachometer-alt fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Dashboard</span>
            </a>

            
            <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fa-solid fa-hand-holding-dollar fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Sales Record</span>
            </a>

            <a href="{{ route('leaderboard') }}" class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fa-solid fa-trophy fw-bold text-warning" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Leaderboard</span>
            </a>

            
            <div class="px-3 mb-2 mt-4 text-uppercase fw-bold" style="font-size: 0.7rem; color: #64748b; letter-spacing: 0.5px;">Management</div>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-chart-line fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Admin Dashboard</span>
            </a>

            <a href="{{ route('admin.employees') }}" class="nav-link {{ request()->routeIs('admin.employees') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-users fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Employees Data</span>
            </a>

            <a href="{{ route('admin.permits.index') }}" class="nav-link {{ request()->routeIs('admin.permits.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-envelope-open-text fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Permit Approval</span>
            </a>

            <a href="{{ route('admin.salary.index') }}" class="nav-link {{ request()->routeIs('admin.salary.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fa-solid fa-money-bill-wave fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">Payroll & Salary</span>
            </a>

            
            <div class="px-3 mb-2 mt-4 text-uppercase fw-bold" style="font-size: 0.7rem; color: #64748b; letter-spacing: 0.5px;">Personal</div>

            
            <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-calendar-check fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">My Attendance</span>
            </a>

             
            <a href="{{ route('permits.index') }}" class="nav-link {{ request()->routeIs('permits.index') ? 'active' : '' }} d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                <i class="fas fa-file-alt fw-bold" style="width: 20px; text-align: center;"></i> 
                <span class="fw-medium">My Permits</span>
            </a>

             
            <div class="mt-4 pt-3 border-top border-secondary border-opacity-25">
                 <a href="#" class="nav-link text-danger d-flex align-items-center gap-3 px-3 py-2 rounded-2 mb-1">
                    <i class="fas fa-sign-out-alt fw-bold" style="width: 20px; text-align: center;"></i> 
                    <span class="fw-medium">Resignation</span>
                </a>
            </div>

        @endif

    </div>

    
    <div class="sidebar-footer dropup p-3 border-top border-white border-opacity-10" style="background-color: #0f172a;">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white w-100 p-2 rounded-3 hover-bg-light-10" id="dropdownAdmin" data-bs-toggle="dropdown" aria-expanded="false">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" width="40" height="40" class="rounded-circle me-3 border border-2 border-primary object-fit-cover">
            @else
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
            @endif
            <div class="d-flex flex-column">
                <span class="fw-bold text-white small text-truncate" style="max-width: 120px;">{{ Auth::user()->name }}</span>
                <span class="text-white-50 text-uppercase" style="font-size: 0.65rem;">{{ Auth::user()->role }}</span>
            </div>
        </a>
        <ul class="dropdown-menu shadow-lg mb-3 border-0 rounded-3 overflow-hidden">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                        <i class="fa-solid fa-power-off"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>