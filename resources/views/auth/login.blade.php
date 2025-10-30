<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - DKM AL-IKLAS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control.error {
            border-color: #ef4444;
        }

        .text-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #6b7280;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .users-info {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .users-info h3 {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
        }

        .users-info ul {
            list-style: none;
        }

        .users-info li {
            padding: 8px 12px;
            background: #f9fafb;
            border-radius: 6px;
            margin-bottom: 8px;
            font-size: 13px;
            color: #6b7280;
        }

        .users-info strong {
            color: #1f2937;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🕌 DKM AL-IKLAS</h1>
            <p>PT Aisin Indonesia</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') error @enderror"
                    value="{{ old('email') }}" placeholder="nama@dkm.com" required autofocus>
                @error('email')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') error @enderror" placeholder="••••••••" required>
                @error('password')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Login
            </button>
        </form>

        <div class="users-info">
            <h3>👥 Akun Demo:</h3>
            <ul>
                <li><strong>Dept PIC:</strong> pic@dkm.com</li>
                <li><strong>Bendahara:</strong> bendahara@dkm.com</li>
                <li><strong>Sekretaris:</strong> sekretaris@dkm.com</li>
                <li><strong>Ketua:</strong> ketua@dkm.com</li>
            </ul>
            <p style="font-size: 12px; color: #9ca3af; margin-top: 12px; text-align: center;">
                Password semua akun: <strong>password</strong>
            </p>
        </div>
    </div>
</body>

</html>
