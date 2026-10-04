<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Surebound Agent & Underwriter Portal Login">
    <title>Agent Login – Surebound Insurance Portal</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sb-navy-950: #070e17;
            --sb-navy-900: #0b1524;
            --sb-emerald-500: #10b981;
            --sb-emerald-600: #059669;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border-subtle: #e2e8f0;
            --radius-md: 10px;
            --radius-lg: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #070e17 0%, #0b1524 50%, #0f1c2e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle glowing aura */
        body::before {
            content: '';
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 1;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: var(--radius-lg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
            padding: 36px 32px;
            position: relative;
            z-index: 2;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .brand-icon-wrap {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .brand-icon-wrap svg {
            width: 24px;
            height: 24px;
            color: #ffffff;
        }

        .brand-name {
            font-size: 1.375rem;
            font-weight: 800;
            color: #0b1524;
            letter-spacing: -0.02em;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .auth-subtitle {
            font-size: 0.8125rem;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        .demo-credentials-box {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: var(--radius-md);
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: 0.75rem;
            color: #065f46;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .demo-credentials-box strong {
            color: #047857;
        }

        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-secondary);
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: var(--text-muted);
        }

        .form-input {
            width: 100%;
            height: 44px;
            padding: 0 14px 0 40px;
            font-size: 0.875rem;
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            background: #ffffff;
            color: var(--text-primary);
            transition: all 0.15s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--sb-emerald-500);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8125rem;
            margin-bottom: 22px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            height: 44px;
            background: linear-gradient(135deg, var(--sb-emerald-600) 0%, var(--sb-emerald-500) 100%);
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 700;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border-subtle);
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        .auth-link {
            color: var(--sb-emerald-600);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
        }

        .back-home:hover {
            color: var(--text-primary);
        }

        .error-alert {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #e11d48;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            font-size: 0.8125rem;
            margin-bottom: 18px;
        }

        .info-alert {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            font-size: 0.8125rem;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-brand">
            <div class="brand-icon-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                </svg>
            </div>
            <span class="brand-name">Surebound</span>
        </div>

        <div class="auth-header">
            <h1 class="auth-title">Agent Portal Login</h1>
            <p class="auth-subtitle">Enter your underwriter credentials to access agency data</p>
        </div>

        <!-- Pre-configured Demo Login Hint -->
        <div class="demo-credentials-box">
            <span><strong>Default Underwriter:</strong> admin@surebound.com</span>
            <span><strong>Password:</strong> password123</span>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('info'))
            <div class="info-alert">
                {{ session('info') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Agent Email</label>
                <div class="input-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
                    </svg>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input" 
                        value="{{ old('email', 'admin@surebound.com') }}" 
                        required 
                        placeholder="agent@surebound.com"
                        autofocus
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                    </svg>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-input" 
                        value="password123" 
                        required 
                        placeholder="••••••••"
                    >
                </div>
            </div>

            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" checked>
                    <span>Remember this device</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Sign In to Portal
            </button>
        </form>

        <div class="auth-footer">
            <p>New broker or underwriter? <a href="{{ route('register') }}" class="auth-link">Register New Agent</a></p>
            <div>
                <a href="/" class="back-home">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    <span>Return to Surebound Homepage</span>
                </a>
            </div>
        </div>
    </div>

</body>
</html>
