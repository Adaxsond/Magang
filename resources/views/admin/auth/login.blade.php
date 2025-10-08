<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        :root {
            --primary-color: #3b5998;
            --secondary-color: #f4f7f9;
            --text-color: #333;
            --gray-color: #9ca3af;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--secondary-color);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(59, 89, 152, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 90%, rgba(224, 242, 241, 0.3) 0%, transparent 50%);
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            margin: 0 20px;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.5s ease-out;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header .logo {
            max-width: 90px;
            margin: 0 auto 20px;
        }

        .login-header .title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 8px;
        }

        .login-header .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px; /* Add padding for icon */
            font-size: 16px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-group .form-control:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 89, 152, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            font-size: 18px;
            transition: color 0.2s ease;
        }

        .form-group .form-control:focus + .input-icon {
            color: var(--primary-color);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .login-btn:hover {
            opacity: 0.9;
            box-shadow: 0 8px 25px rgba(59, 89, 152, 0.3);
        }
        
        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Universitas" class="logo">
                <h1 class="title">Admin Portal</h1>
                <p class="subtitle">Silakan masuk untuk melanjutkan</p>
            </div>

            @error('email')
                <div class="alert-danger">{{ $message }}</div>
            @enderror

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@mail.com">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" placeholder="Masukkan password">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>