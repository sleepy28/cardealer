<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dealer Boss - Admin Panel')</title>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('styles')

    <style>
        
        body { 
            font-family: 'Inter', 'Segoe UI', sans-serif; 
            background-color: #f8f9fa; 
            overflow-x: hidden; 
        }
        
        
        .main-content {
            margin-left: 280px; 
            padding: 30px;
            min-height: 100vh;
            width: auto;
            transition: margin-left 0.3s ease;
        }

        
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0 !important;
                padding: 20px 15px; 
                padding-top: 20px; 
            }
        }

    
        .theme-toggle-btn {
            background-color: rgba(255, 255, 255, 0.1); 
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 26px;
            border-radius: 50px; 
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5px;
            transition: all 0.3s ease;
            outline: none; 
        }
        
        
        .toggle-ball {
            position: absolute;
            top: 3px; 
            left: 3px;
            width: 18px; 
            height: 18px;
            background-color: #fff;
            border-radius: 50%;
            transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            z-index: 2;
        }

        
        .icon-sun, .icon-moon {
            font-size: 11px;
            z-index: 1;
            transition: opacity 0.3s;
            pointer-events: none; 
        }
        .icon-sun { opacity: 1; }
        .icon-moon { opacity: 0.3; }

 

        
        [data-bs-theme="dark"] .toggle-ball {
            transform: translateX(24px); 
            background-color: #3b82f6; 
        }
        [data-bs-theme="dark"] .icon-sun { opacity: 0.3; }
        [data-bs-theme="dark"] .icon-moon { opacity: 1; }

        
        [data-bs-theme="dark"] body {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        
        [data-bs-theme="dark"] .bg-white, 
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .list-group-item {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, 
        [data-bs-theme="dark"] h3, [data-bs-theme="dark"] h4, 
        [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6,
        [data-bs-theme="dark"] strong, [data-bs-theme="dark"] b {
            color: #f8f9fa !important;
        }

        
        [data-bs-theme="dark"] .text-muted, 
        [data-bs-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }

        
        [data-bs-theme="dark"] .table {
            color: #e2e8f0 !important;
            border-color: #334155;
        }
        [data-bs-theme="dark"] .table thead th {
            background-color: #1e293b !important;
            color: #fff !important;
            border-bottom: 2px solid #334155;
        }
        [data-bs-theme="dark"] .table td {
            background-color: #1e293b !important;
            border-bottom: 1px solid #334155;
        }

        
        [data-bs-theme="dark"] .form-control, 
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #fff !important;
        }
        [data-bs-theme="dark"] .form-control::placeholder {
            color: #64748b !important;
        }

        
        body, .card, .bg-white, .table, h1, h2, h3, span, div {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('themeToggle');
            const htmlElement = document.documentElement;
            
            // Cek settingan tersimpan
            const savedTheme = localStorage.getItem('theme') || 'light';
            htmlElement.setAttribute('data-bs-theme', savedTheme);

            if(toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const currentTheme = htmlElement.getAttribute('data-bs-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    htmlElement.setAttribute('data-bs-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>