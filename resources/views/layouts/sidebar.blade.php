<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --sidebar-width: 280px;
        --sidebar-bg: #0f172a;
        --sidebar-border: rgba(255, 255, 255, 0.08);
        --header-height-mobile: 64px;
        --primary-color: #3b82f6;
        --text-secondary: #94a3b8;
    }

 
    #sidebar-wrapper {
        font-family: 'Inter', sans-serif;
        width: var(--sidebar-width);
        
    
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        height: 100vh;
        height: 100dvh;  
        
        background-color: var(--sidebar-bg);
        z-index: 1050;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-right: 1px solid var(--sidebar-border);
        box-shadow: 4px 0 24px rgba(0,0,0,0.3);
    }

    .nav-scroll {
        flex-grow: 1;
        overflow-y: auto;
        padding: 15px 14px;
        scrollbar-width: thin;
        scrollbar-color: #334155 transparent;
    }
    .nav-scroll::-webkit-scrollbar { width: 4px; }
    .nav-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

  
    .menu-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #64748b;
        font-weight: 700;
        margin: 20px 0 8px 12px;
    }

    .nav-link-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.95rem;
        border-radius: 8px;
        font-weight: 500;
 
        transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border-left: 3px solid transparent;
    }

    .nav-link-modern i { 
        width: 24px; 
        text-align: center; 
        transition: transform 0.2s ease, color 0.2s ease;
    }

   
    .nav-link-modern:hover {
        background-color: rgba(255, 255, 255, 0.08);
        color: #fff;
        transform: translateX(5px);  
        box-shadow: 2px 2px 8px rgba(0,0,0,0.2);  
    }

    .nav-link-modern:hover i {
        color: var(--primary-color);  
        transform: scale(1.15); 
    }

   
    .nav-link-modern.active {
        background: linear-gradient(90deg, rgba(59,130,246,0.15), transparent);
        color: #60a5fa;
        border-left-color: #3b82f6;
    }
    
    .nav-link-modern.active i {
        color: #60a5fa;
    }

    
    .mobile-header {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0;
        height: var(--header-height-mobile);
        background-color: var(--sidebar-bg);
        z-index: 1030;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        border-bottom: 1px solid var(--sidebar-border);
    }

    .mobile-spacer {
        display: none;
        height: var(--header-height-mobile);
        width: 100%;
    }

    @media (max-width: 991.98px) {
        #sidebar-wrapper { transform: translateX(-100%); }
        #sidebar-wrapper.show { transform: translateX(0); }
        .mobile-header { display: flex; }
        .mobile-spacer { display: block; }
        
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(3px);
            z-index: 1040;
            display: none; opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.show { display: block; opacity: 1; }
    }
    
    @media (min-width: 992px) {
        .sidebar-close-btn { display: none !important; }
    }

 
    .user-profile {
        padding: 16px;
        background: rgba(0,0,0,0.2);
        border-top: 1px solid var(--sidebar-border);
        margin-top: auto;
    }
</style>



 
<div class="mobile-header">
    <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('img/logonusa.png') }}" alt="Logo" style="height: 30px; width: auto;">
        <span class="text-white fw-bold tracking-wide" style="font-size: 1.1rem;">NUSA <span class="text-primary" style="font-size: 0.8rem;">DEALER</span></span>
    </div>
    <button class="btn btn-link text-white p-1" onclick="toggleSidebar()">
        <i class="fas fa-bars fa-lg"></i>
    </button>
</div>
<div class="mobile-spacer"></div>

 
<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>


<nav id="sidebar-wrapper">
    
    <div class="d-flex align-items-center justify-content-between px-4 py-4" style="min-height: 80px;">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('img/logonusa.png') }}" alt="Nusa" style="height: 36px; width: auto;">
            <div class="d-flex flex-column" style="line-height: 1.1;">
                <span class="fw-bold text-white fs-5">NUSA</span>
                <span class="text-primary fw-bold" style="font-size: 0.6rem; letter-spacing: 2px;">DEALER</span>
            </div>
        </div>
        <button class="sidebar-close-btn btn btn-link text-secondary p-0" onclick="toggleSidebar()">
            <i class="fas fa-times fs-4"></i>
        </button>
    </div>

    
    <div class="nav-scroll">
        @if(Auth::user()->role === 'admin')
    
            <div class="menu-label">Admin Control</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link-modern {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('leaderboard') }}" class="nav-link-modern {{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                <i class="fas fa-trophy text-warning"></i> <span>Leaderboard</span>
            </a>
            <a href="{{ route('admin.employees') }}" class="nav-link-modern {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Employees</span>
            </a>
            <a href="{{ route('admin.permits.index') }}" class="nav-link-modern {{ request()->routeIs('admin.permits.*') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text"></i> <span>Permit Approval</span>
            </a>

            <div class="menu-label">Finance System</div>
            <a href="{{ route('admin.salary.index') }}" class="nav-link-modern {{ request()->routeIs('admin.salary.index') ? 'active' : '' }}">
                <i class="fas fa-wallet text-success"></i> <span>Payroll & Komisi</span>
            </a>
            <a href="{{ route('admin.salary.report') }}" class="nav-link-modern {{ request()->routeIs('admin.salary.report') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> <span>Salary Report</span>
            </a>
            <a href="{{ route('admin.salary_settings.index') }}" class="nav-link-modern {{ request()->routeIs('admin.salary_settings.*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h text-primary"></i> <span>Setting Gaji</span>
            </a>
            <a href="{{ route('admin.commission.index') }}" class="nav-link-modern {{ request()->routeIs('admin.commission.*') ? 'active' : '' }}">
                <i class="fas fa-percent text-info"></i> <span>Master Komisi</span>
            </a>

        @elseif(Auth::user()->role === 'finance')
          
            <div class="menu-label">Main Menu</div>
            <a href="{{ route('dashboard') }}" class="nav-link-modern {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('dashboard.duty-salary') }}" class="nav-link-modern {{ request()->routeIs('dashboard.duty-salary') ? 'active' : '' }}">
                <i class="fas fa-coins text-warning"></i> <span>Duty Salary</span>
            </a>
            <a href="{{ route('sales.index') }}" class="nav-link-modern {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> <span>Sales Record</span>
            </a>
            
            <a href="{{ route('leaderboard') }}" class="nav-link-modern {{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                <i class="fas fa-trophy text-warning"></i> <span>Leaderboard</span>
            </a>

            <div class="menu-label">Finance Tools</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link-modern {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-user-shield text-info"></i> <span>Admin Dashboard</span>
            </a>
            <a href="{{ route('admin.employees') }}" class="nav-link-modern {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Employees</span>
            </a>
            <a href="{{ route('admin.permits.index') }}" class="nav-link-modern {{ request()->routeIs('admin.permits.*') ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i> <span>Permit Approval</span>
            </a>
            
            <a href="{{ route('admin.salary.index') }}" class="nav-link-modern {{ request()->routeIs('admin.salary.*') ? 'active' : '' }}">
                <i class="fas fa-money-check-alt text-success"></i> <span>Payroll System</span>
            </a>
           
            <a href="{{ route('permit.index') }}" class="nav-link-modern {{ request()->routeIs('permit.index') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> <span>Permits Application</span>
            </a>

        @else 
        
            <div class="menu-label">Workspace</div>
            <a href="{{ route('dashboard') }}" class="nav-link-modern {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('dashboard.duty-salary') }}" class="nav-link-modern {{ request()->routeIs('dashboard.duty-salary') ? 'active' : '' }}">
                <i class="fas fa-wallet text-success"></i> <span>Duty Salary</span>
            </a>
            <a href="{{ route('sales.index') }}" class="nav-link-modern {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> <span>Sales Record</span>
            </a>
            <a href="{{ route('leaderboard') }}" class="nav-link-modern {{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                <i class="fas fa-medal text-warning"></i> <span>Leaderboard</span>
            </a>
            
            <div class="menu-label">Personal</div>
            <a href="#" class="nav-link-modern">
                <i class="fas fa-clock"></i> <span>My Attendance</span>
            </a>
            <a href="{{ route('permit.index') }}" class="nav-link-modern {{ request()->routeIs('permit.index') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> <span>Permit Application</span>
            </a>
             <div class="mt-4 px-2">
                 <a href="#" class="nav-link-modern text-danger bg-danger bg-opacity-10 justify-content-center border border-danger border-opacity-25">
                    <i class="fas fa-sign-out-alt"></i> <span>Resignation</span>
                </a>
            </div>
        @endif
    </div>

  
    <div class="user-profile">
        <div class="d-flex align-items-center justify-content-between w-100">
            
            
            <div class="dropup flex-grow-1" style="min-width: 0; margin-right: 10px;">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white w-100" data-bs-toggle="dropdown">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="rounded-circle me-3 border border-2 border-primary" width="40" height="40" style="object-fit: cover;">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; font-weight: bold; flex-shrink: 0;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="d-flex flex-column overflow-hidden">
                        <span class="fw-semibold text-white small text-truncate">{{ Auth::user()->name }}</span>
                        <span class="text-white-50 small text-uppercase" style="font-size: 0.65rem;">{{ Auth::user()->role }}</span>
                    </div>
                </a>
                <ul class="dropdown-menu shadow-lg mb-2 border-0 rounded-3">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                            <i class="fa-solid fa-user-gear text-secondary me-2"></i> My Account
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-semibold">
                                <i class="fa-solid fa-power-off me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

       
            <button id="themeToggle" class="theme-toggle-btn" title="Switch Theme">
                <i class="fas fa-sun text-warning icon-sun"></i>
                <i class="fas fa-moon text-white icon-moon"></i>
                <div class="toggle-ball"></div>
            </button>

        </div>
    </div>
</nav>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar-wrapper');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
</script>