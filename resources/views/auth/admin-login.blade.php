<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Satu Jarak</title>
    <!-- Favicon / Logo Satu Jarak -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <!-- Simple styling for demonstration, replace with your app's actual CSS -->
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f3f4f6; }
        .login-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 0.75rem; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-submit:hover { background-color: #dc2626; }
        .error-message { color: red; font-size: 0.875rem; margin-top: 0.25rem; }
    </style>
</head>
<body>

<div class="login-card">
    <div style="text-align: center; margin-bottom: 1.5rem;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SatuJarak" style="width: 72px; height: 72px; object-fit: contain; margin-bottom: 0.5rem;">
        <h2 style="margin: 0; color: #0B3828; font-size: 1.4rem; font-weight: bold;">Satu Jarak</h2>
        <p style="margin: 0.25rem 0 0; color: #708078; font-size: 0.85rem;">Portal Admin Pelayanan Publik Desa</p>
    </div>
    
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email Admin</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Login Sekarang</button>
    </form>
</div>

</body>
</html>
