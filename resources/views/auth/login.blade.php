<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Kebun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Latar belakang nuansa perkebunan sawit premium dari Unsplash */
            background: url('https://images.unsplash.com/photo-1598322640237-781e6498a44d?q=80&w=2070&auto=format&fit=crop') no-repeat center center fixed; 
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6); /* Efek gelap agar elegan */
            z-index: 1;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 45px 40px;
            width: 100%;
            max-width: 420px;
            z-index: 2;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            color: white;
        }
        .login-card h3 {
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 15px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.4);
            background: #ffffff;
        }
        .btn-login {
            background: #198754;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: bold;
            font-size: 16px;
            letter-spacing: 1px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.4);
        }
        .btn-login:hover {
            background: #146c43;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(25, 135, 84, 0.6);
        }
        .icon-lock {
            text-align: center;
            margin-bottom: 15px;
        }
        .form-check-label {
            font-weight: 300;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    
    <div class="login-card">
        <div class="icon-lock">
            <!-- Ikon Keamanan Premium -->
            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" fill="#20c997" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5z"/>
            </svg>
        </div>
        
        <h3>Portal Manajemen</h3>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Alamat Email">
                @error('email')
                    <span class="invalid-feedback text-warning mb-3 d-block" role="alert">
                        <strong>Kredensial tidak cocok dengan data kami.</strong>
                    </span>
                @enderror
            </div>

            <div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Kata Sandi">
            </div>

            <div class="mb-4 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Ingat Sesi Saya
                </label>
            </div>

            <button type="submit" class="btn btn-login text-white">
                MASUK KE SISTEM
            </button>
        </form>
    </div>
</body>
</html>
