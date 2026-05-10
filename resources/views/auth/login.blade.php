<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartPark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: linear-gradient(135deg, #0a0f1e 0%, #0f1f3d 50%, #0a1628 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* ========== BACKGROUND SCENE ========== */
        .bg-scene {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        /* Road - horizontal strip */
        .road {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 130px;
            background: #1a1a2e;
            opacity: 0.6;
        }

        /* Road markings */
        .road-line {
            position: absolute;
            bottom: 60px;
            height: 8px;
            width: 80px;
            background: #f59e0b;
            opacity: 0.4;
            border-radius: 4px;
            animation: dashMove 3s linear infinite;
        }

        @keyframes dashMove {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-160px); }
        }

        /* Parking sign P */
        .sign-p {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0.18;
        }

        .sign-p .sign-board {
            width: 54px;
            height: 54px;
            background: #2563eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 900;
            color: white;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 0 20px rgba(37,99,235,0.4);
        }

        .sign-p .sign-pole {
            width: 5px;
            height: 80px;
            background: #94a3b8;
            border-radius: 2px;
        }

        /* Parking barrier / palang */
        .barrier {
            position: absolute;
            opacity: 0.15;
        }

        .barrier-arm {
            height: 14px;
            border-radius: 7px;
            background: repeating-linear-gradient(
                90deg,
                #ef4444 0px,
                #ef4444 20px,
                #f8fafc 20px,
                #f8fafc 40px
            );
            transform-origin: left center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
        }

        .barrier-post {
            width: 16px;
            height: 50px;
            background: linear-gradient(180deg, #64748b, #334155);
            border-radius: 4px 4px 0 0;
            margin-left: 4px;
        }

        /* Speed limit sign */
        .sign-speed {
            position: absolute;
            opacity: 0.15;
        }

        .sign-speed .circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: white;
            border: 5px solid #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            font-family: 'Inter', sans-serif;
        }

        .sign-speed .pole {
            width: 5px;
            height: 70px;
            background: #94a3b8;
            border-radius: 2px;
            margin: 0 auto;
        }

        /* CCTV icon */
        .cctv {
            position: absolute;
            opacity: 0.12;
        }

        /* Car silhouette */
        .car-silhouette {
            position: absolute;
            opacity: 0.08;
            bottom: 20px;
        }

        /* Floating grid dots */
        .grid-dots {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(59,130,246,0.15) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Glow orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.12;
            pointer-events: none;
        }

        .orb-1 { width: 400px; height: 400px; background: #3b82f6; top: -100px; left: -100px; }
        .orb-2 { width: 300px; height: 300px; background: #0ea5e9; bottom: -80px; right: -80px; }
        .orb-3 { width: 200px; height: 200px; background: #6366f1; top: 40%; left: 30%; }

        /* Animated barrier */
        .barrier-animated .barrier-arm {
            animation: barrierOpen 4s ease-in-out infinite;
        }

        @keyframes barrierOpen {
            0%, 40%   { transform: rotate(0deg); }
            50%, 90%  { transform: rotate(-75deg); }
            100%      { transform: rotate(0deg); }
        }

        /* ========== LOGIN CARD ========== */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 16px;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow:
                0 25px 60px rgba(0,0,0,0.5),
                inset 0 1px 0 rgba(255,255,255,0.06);
            color: white;
        }

        /* Logo area */
        .brand-area {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 8px 24px rgba(37,99,235,0.4);
        }

        .brand-icon svg {
            width: 36px;
            height: 36px;
            fill: white;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.5px;
        }

        .brand-sub {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Form elements */
        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 15px;
            pointer-events: none;
        }

        .input-group-custom input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 13px 14px 13px 42px;
            color: #f1f5f9;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .input-group-custom input::placeholder { color: #475569; }

        .input-group-custom input:focus {
            border-color: #3b82f6;
            background: rgba(59,130,246,0.08);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-row label {
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
        }

        .remember-row input[type=checkbox] {
            accent-color: #3b82f6;
            width: 15px;
            height: 15px;
        }

        .remember-row a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 500;
        }

        .remember-row a:hover { color: #93c5fd; }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(37,99,235,0.35);
            letter-spacing: 0.2px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            box-shadow: 0 6px 20px rgba(37,99,235,0.5);
            transform: translateY(-1px);
        }

        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #334155;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.07);
        }

        .btn-google {
            width: 100%;
            padding: 13px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: #e2e8f0;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-google:hover {
            background: rgba(255,255,255,0.09);
            border-color: rgba(255,255,255,0.18);
            color: white;
        }

        /* Error messages */
        .alert-error {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: #fca5a5;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* road lines stagger */
        .rl-1 { left: 5%;  animation-delay: 0s; }
        .rl-2 { left: 25%; animation-delay: -0.7s; }
        .rl-3 { left: 45%; animation-delay: -1.4s; }
        .rl-4 { left: 65%; animation-delay: -2.1s; }
        .rl-5 { left: 85%; animation-delay: -2.8s; }
    </style>
</head>
<body>

<!-- ===== BACKGROUND SCENE ===== -->
<div class="bg-scene">
    <div class="grid-dots"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Road strip -->
    <div class="road"></div>

    <!-- Road dashed lines -->
    <div class="road-line rl-1"></div>
    <div class="road-line rl-2"></div>
    <div class="road-line rl-3"></div>
    <div class="road-line rl-4"></div>
    <div class="road-line rl-5"></div>

    <!-- Parking Sign P (left) -->
    <div class="sign-p" style="left: 7%; bottom: 130px;">
        <div class="sign-board">P</div>
        <div class="sign-pole"></div>
    </div>

    <!-- Parking Sign P (right, smaller) -->
    <div class="sign-p" style="right: 9%; bottom: 130px; transform: scale(0.75);">
        <div class="sign-board">P</div>
        <div class="sign-pole"></div>
    </div>

    <!-- Speed limit sign (far left) -->
    <div class="sign-speed" style="left: 18%; bottom: 130px;">
        <div class="circle">30</div>
        <div class="pole"></div>
    </div>

    <!-- Speed limit sign (far right) -->
    <div class="sign-speed" style="right: 18%; bottom: 130px; transform: scale(0.8);">
        <div class="circle">15</div>
        <div class="pole"></div>
    </div>

    <!-- Barrier LEFT (animated) -->
    <div class="barrier barrier-animated" style="left: 2%; bottom: 130px;">
        <div class="barrier-post"></div>
        <div class="barrier-arm" style="width: 180px;"></div>
    </div>

    <!-- Barrier RIGHT (static, raised) -->
    <div class="barrier" style="right: 3%; bottom: 130px;">
        <div class="barrier-post"></div>
        <div class="barrier-arm" style="width: 140px; transform: rotate(-75deg);"></div>
    </div>

    <!-- CCTV Left top -->
    <div class="cctv" style="left: 5%; top: 8%;">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="#94a3b8">
            <path d="M2 8.5A1.5 1.5 0 0 1 3.5 7h13A1.5 1.5 0 0 1 18 8.5v1l3-2v7l-3-2v1A1.5 1.5 0 0 1 16.5 15h-13A1.5 1.5 0 0 1 2 13.5v-5z"/>
            <line x1="8" y1="15" x2="8" y2="18" stroke="#94a3b8" stroke-width="1.5"/>
            <line x1="5" y1="18" x2="11" y2="18" stroke="#94a3b8" stroke-width="1.5"/>
        </svg>
    </div>

    <!-- CCTV Right top -->
    <div class="cctv" style="right: 6%; top: 10%; transform: scaleX(-1);">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="#94a3b8">
            <path d="M2 8.5A1.5 1.5 0 0 1 3.5 7h13A1.5 1.5 0 0 1 18 8.5v1l3-2v7l-3-2v1A1.5 1.5 0 0 1 16.5 15h-13A1.5 1.5 0 0 1 2 13.5v-5z"/>
            <line x1="8" y1="15" x2="8" y2="18" stroke="#94a3b8" stroke-width="1.5"/>
            <line x1="5" y1="18" x2="11" y2="18" stroke="#94a3b8" stroke-width="1.5"/>
        </svg>
    </div>

    <!-- Car silhouette left -->
    <div class="car-silhouette" style="left: 5%;">
        <svg width="140" height="60" viewBox="0 0 200 80" fill="#60a5fa">
            <rect x="20" y="35" width="160" height="30" rx="8"/>
            <rect x="50" y="15" width="100" height="28" rx="8"/>
            <circle cx="55" cy="68" r="12" fill="#1e3a5f"/>
            <circle cx="145" cy="68" r="12" fill="#1e3a5f"/>
            <circle cx="55" cy="68" r="6" fill="#2d5f8a"/>
            <circle cx="145" cy="68" r="6" fill="#2d5f8a"/>
            <rect x="155" y="38" width="20" height="12" rx="3" fill="#fbbf24" opacity="0.6"/>
            <rect x="25"  y="38" width="20" height="12" rx="3" fill="#ef4444" opacity="0.5"/>
        </svg>
    </div>

    <!-- Car silhouette right (smaller) -->
    <div class="car-silhouette" style="right: 8%; transform: scaleX(-1); opacity: 0.05;">
        <svg width="110" height="50" viewBox="0 0 200 80" fill="#60a5fa">
            <rect x="20" y="35" width="160" height="30" rx="8"/>
            <rect x="50" y="15" width="100" height="28" rx="8"/>
            <circle cx="55" cy="68" r="12" fill="#1e3a5f"/>
            <circle cx="145" cy="68" r="12" fill="#1e3a5f"/>
            <circle cx="55" cy="68" r="6" fill="#2d5f8a"/>
            <circle cx="145" cy="68" r="6" fill="#2d5f8a"/>
            <rect x="155" y="38" width="20" height="12" rx="3" fill="#fbbf24" opacity="0.6"/>
        </svg>
    </div>
</div>
<!-- ===== END BACKGROUND ===== -->

<!-- ===== LOGIN FORM ===== -->
<div class="login-wrapper">
    <div class="login-card">

        <!-- Brand -->
        <div class="brand-area">
            <div class="brand-icon">
                <!-- Parking P icon -->
                <svg viewBox="0 0 24 24" fill="white">
                    <path d="M6 3h6a6 6 0 0 1 0 12H9v6H6V3zm3 9h3a3 3 0 0 0 0-6H9v6z"/>
                </svg>
            </div>
            <div class="brand-name">SmartPark</div>
            <div class="brand-sub">Sistem Manajemen Parkir Cerdas</div>
        </div>

        <!-- Error -->
        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Session status -->
        @if(session('status'))
        <div class="alert-error" style="background:rgba(16,185,129,0.12); border-color:rgba(16,185,129,0.25); color:#6ee7b7;">
            <i class="fas fa-check-circle"></i>
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-1">
                <label class="form-label">Alamat Email</label>
            </div>
            <div class="input-group-custom">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="contoh@email.com"
                    value="{{ old('email') }}" required autocomplete="email">
            </div>

            <!-- Password -->
            <div class="mb-1">
                <label class="form-label">Password</label>
            </div>
            <div class="input-group-custom">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" placeholder="Masukkan password"
                    required autocomplete="current-password">
            </div>

            <!-- Remember & Forgot -->
            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk
            </button>
        </form>

        <div class="divider">atau lanjutkan dengan</div>

        <a href="{{ route('google.login') }}" class="btn-google">
            <svg width="18" height="18" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.8 32.9 29.4 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.7 1.1 7.8 2.9l5.7-5.7C34.5 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 16.1 18.9 13 24 13c3 0 5.7 1.1 7.8 2.9l5.7-5.7C34.5 6.1 29.6 4 24 4 16.3 4 9.7 8.4 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.3 0 10.2-2 13.9-5.3l-6.4-5.2C29.5 35.3 26.9 36 24 36c-5.4 0-9.9-3.1-11.5-7.6l-6.6 5.1C9.6 39.6 16.3 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.3 5.7-6.1 7.3l6.4 5.2C39.5 36.9 44 30.9 44 24c0-1.3-.1-2.7-.4-3.5z"/>
            </svg>
            Login dengan Google
        </a>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>