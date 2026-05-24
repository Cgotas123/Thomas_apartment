<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Thomas Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; }
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            position: relative;
            overflow: hidden;
        }
        .login-page::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }
        .login-page::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(168,85,247,0.1) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
        }
        .login-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 36px;
        }
        .brand-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            color: #fff;
            box-shadow: 0 8px 24px rgba(59,130,246,0.3);
        }
        .login-brand h3 {
            color: #f1f5f9;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 4px;
        }
        .login-brand p {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 400;
        }
        .form-label {
            color: #cbd5e1;
            font-weight: 500;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }
        .input-group-text {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #94a3b8;
        }
        .form-control {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #f1f5f9;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.08);
            border-color: #3b82f6;
            color: #f1f5f9;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
        .form-control::placeholder {
            color: #64748b;
        }
        .form-check-input {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }
        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .form-check-label {
            color: #94a3b8;
            font-size: 0.85rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            padding: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 12px;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(59,130,246,0.3);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59,130,246,0.4);
            color: #fff;
        }
        .alert-danger {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 12px;
            font-size: 0.88rem;
        }
        .credentials-hint {
            margin-top: 24px;
            padding: 16px;
            background: rgba(59,130,246,0.08);
            border: 1px solid rgba(59,130,246,0.15);
            border-radius: 12px;
            text-align: center;
        }
        .credentials-hint p {
            color: #94a3b8;
            font-size: 0.8rem;
            margin-bottom: 4px;
        }
        .credentials-hint code {
            color: #93c5fd;
            font-size: 0.8rem;
            background: rgba(59,130,246,0.1);
            padding: 2px 8px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-brand">
                <div class="brand-icon"><i class="bi bi-building"></i></div>
                <h3>Thomas Apartment</h3>
                <p>Management System</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@thomas-apartment.com">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                    </div>
                </div>
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-login w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                </button>
            </form>

            <div class="credentials-hint">
                <p><strong style="color:#cbd5e1">Default Credentials</strong></p>
                <p>Admin: <code>admin@thomas-apartment.com</code></p>
                <p>Caretaker: <code>caretaker@thomas-apartment.com</code></p>
                <p>Password: <code>password</code></p>
            </div>
        </div>
    </div>
</body>
</html>
