<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dealer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { height: 100%; margin: 0; font-family: 'Segoe UI', sans-serif; }
        
        
        .login-image {
            background-image: url("{{ asset('img/login-bg.png') }}"); 
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        
        .login-form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: white;
        }

        .login-box { width: 100%; max-width: 400px; padding: 20px; }
        .logo-img { max-width: 180px; margin-bottom: 20px; }
        
         
        .form-control {
            background-color: #f3f4f6; 
            border: 1px solid #e5e7eb;
            padding: 12px;
            border-radius: 8px;
        }
        .form-control:focus {
            background-color: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background-color: #3b82f6; 
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-primary:hover { background-color: #2563eb; }
        .server-name { font-weight: bold; font-size: 1.2rem; margin-top: 10px; }
        .company-name { color: #6b7280; font-size: 0.9rem; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-7 col-lg-8 d-none d-md-block login-image"></div>

        <div class="col-md-5 col-lg-4 login-form-container">
            <div class="login-box text-center">
                
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-img">
                
                <div class="server-name">Nusa V</div>
                <div class="company-name">Dealer Management System</div>

                @if($errors->any())
                    <div class="alert alert-danger text-start py-2" style="font-size: 0.9rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="text-start">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="........" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label small text-secondary" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">Sign in</button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>