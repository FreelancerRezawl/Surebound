<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Setup | Surebound</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --primary-hover: #1e293b;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #334155;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
            --danger: #ef4444;
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .setup-container {
            background: var(--card-bg);
            width: 100%;
            max-width: 600px;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .setup-header {
            background: var(--primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .setup-header h1 {
            font-size: 1.625rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .setup-header p {
            color: #94a3b8;
            font-size: 1.075rem;
        }

        .setup-body {
            padding: 2.5rem;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border);
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            background: var(--card-bg);
            padding: 0 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--bg);
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .step.active .step-circle {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .step.completed .step-circle {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .step-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .step.active .step-label {
            color: var(--accent);
        }

        h2 {
            font-size: 1.375rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1.125rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.125rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: var(--primary);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            line-height: 1.5;
        }

        .alert-error {
            background: #fef2f2;
            color: var(--danger);
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: var(--success);
            border: 1px solid #bbf7d0;
        }

        .req-list {
            list-style: none;
            margin-bottom: 2rem;
        }

        .req-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 1.075rem;
        }

        .req-item:last-child {
            border-bottom: none;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-pass {
            background: #dcfce7;
            color: #166534;
        }

        .status-fail {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .setup-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .text-center { text-align: center; }
        .mt-4 { margin-top: 1rem; }
    </style>
</head>
<body>

    <div class="setup-container">
        <div class="setup-header">
            <h1>Surebound Setup Wizard</h1>
            <p>Configure your application in a few easy steps</p>
        </div>

        <div class="setup-body">
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step {{ $step >= 1 ? 'active' : '' }} {{ $step > 1 ? 'completed' : '' }}">
                    <div class="step-circle">{{ $step > 1 ? '✓' : '1' }}</div>
                    <span class="step-label">Check</span>
                </div>
                <div class="step {{ $step >= 2 ? 'active' : '' }} {{ $step > 2 ? 'completed' : '' }}">
                    <div class="step-circle">{{ $step > 2 ? '✓' : '2' }}</div>
                    <span class="step-label">Database</span>
                </div>
                <div class="step {{ $step >= 3 ? 'active' : '' }} {{ $step > 3 ? 'completed' : '' }}">
                    <div class="step-circle">{{ $step > 3 ? '✓' : '3' }}</div>
                    <span class="step-label">Migrate</span>
                </div>
                <div class="step {{ $step >= 4 ? 'active' : '' }} {{ $step > 4 ? 'completed' : '' }}">
                    <div class="step-circle">{{ $step > 4 ? '✓' : '4' }}</div>
                    <span class="step-label">Admin</span>
                </div>
                <div class="step {{ $step >= 5 ? 'active' : '' }} {{ $step > 5 ? 'completed' : '' }}">
                    <div class="step-circle">{{ $step > 5 ? '✓' : '5' }}</div>
                    <span class="step-label">Done</span>
                </div>
            </div>

            <!-- STEP 1: Requirements -->
            @if($step == 1)
                <h2>System Requirements</h2>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.075rem;">Please make sure your server meets the following requirements before continuing.</p>
                
                <ul class="req-list">
                    @foreach($requirements as $requirement => $passed)
                        <li class="req-item">
                            <span>{{ $requirement }}</span>
                            @if($passed)
                                <span class="status-badge status-pass">Pass</span>
                            @else
                                <span class="status-badge status-fail">Fail</span>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if($allRequirementsPassed)
                    <a href="{{ route('setup.database') }}" class="btn btn-primary">Continue to Database Setup &rarr;</a>
                @else
                    <button class="btn btn-primary" disabled style="opacity: 0.5; cursor: not-allowed;">Please fix requirements to continue</button>
                @endif
            @endif

            <!-- STEP 2: Database Configuration -->
            @if($step == 2)
                <h2>Database Configuration</h2>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.075rem;">Enter your database connection details below.</p>
                
                <form action="{{ route('setup.database.save') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Database Host</label>
                        <input type="text" name="db_host" class="form-input" value="127.0.0.1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Database Port</label>
                        <input type="text" name="db_port" class="form-input" value="3306" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Database Name</label>
                        <input type="text" name="db_database" class="form-input" required placeholder="e.g. surebound_db">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Database Username</label>
                        <input type="text" name="db_username" class="form-input" required placeholder="e.g. root">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Database Password</label>
                        <input type="password" name="db_password" class="form-input" placeholder="Leave blank if none">
                    </div>
                    
                    <div class="setup-actions">
                        <a href="{{ route('setup.welcome') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Save & Continue &rarr;</button>
                    </div>
                </form>
            @endif

            <!-- STEP 3: Migrations -->
            @if($step == 3)
                <h2>Run Migrations</h2>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.075rem;">Your database configuration is saved. We now need to build the database structure by running migrations.</p>
                
                <div class="alert alert-success">Database connected successfully!</div>

                <form action="{{ route('setup.migrations.run') }}" method="POST">
                    @csrf
                    <div class="setup-actions">
                        <a href="{{ route('setup.database') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Run Database Migrations &rarr;</button>
                    </div>
                </form>
            @endif

            <!-- STEP 4: Admin Account -->
            @if($step == 4)
                <h2>Create Admin Account</h2>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.075rem;">Create the primary administrator account to manage your platform.</p>
                
                <form action="{{ route('setup.admin.save') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Admin Name</label>
                        <input type="text" name="name" class="form-input" required placeholder="e.g. John Doe">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Admin Email</label>
                        <input type="email" name="email" class="form-input" required placeholder="e.g. admin@surebound.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-input" required minlength="8">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-4">Create Admin & Finish Setup</button>
                </form>
            @endif

            <!-- STEP 5: Complete -->
            @if($step == 5)
                <div class="text-center">
                    <div style="font-size: 50px; margin-bottom: 1rem;">🎉</div>
                    <h2>Setup Complete!</h2>
                    <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 1.125rem; line-height: 1.6;">Your Surebound application has been successfully installed and configured. You can now login to your admin dashboard.</p>
                    
                    <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
