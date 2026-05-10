<aside style="
    width: 210px;
    min-width: 210px;
    height: 100vh;
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
    border-right: 1px solid rgba(255,255,255,0.06);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    overflow-x: hidden;
">

    {{-- ===== LOGO AREA ===== --}}
    <div style="padding: 20px 16px 16px; border-bottom: 1px solid rgba(255,255,255,0.06);">
        <div style="display:flex; align-items:center; gap:10px;">
            {{-- Icon logo P --}}
            <div style="
                width: 36px; height: 36px; flex-shrink:0;
                background: linear-gradient(135deg, #2563eb, #3b82f6);
                border-radius: 10px;
                display: flex; align-items:center; justify-content:center;
                box-shadow: 0 4px 12px rgba(37,99,235,0.4);
            ">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                    <path d="M6 3h6a6 6 0 0 1 0 12H9v6H6V3zm3 9h3a3 3 0 0 0 0-6H9v6z"/>
                </svg>
            </div>
            <div>
                <div style="font-size:15px; font-weight:700; color:#f1f5f9; letter-spacing:-0.3px; line-height:1.1;">SmartPark</div>
                <div style="font-size:10px; color:#475569; margin-top:1px;">Parking Management</div>
            </div>
        </div>
    </div>

    {{-- ===== NAV AREA ===== --}}
    <nav style="flex:1; padding: 12px 10px;">

        {{-- GROUP: UTAMA --}}
        <div style="font-size:10px; font-weight:600; color:#334155; text-transform:uppercase; letter-spacing:0.8px; padding: 0 8px; margin-bottom:6px;">
            Menu Utama
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" style="
            display:flex; align-items:center; gap:10px;
            padding: 9px 10px; border-radius:8px; margin-bottom:2px;
            font-size:13px; font-weight:500; text-decoration:none;
            transition: all 0.15s;
            {{ request()->routeIs('dashboard') 
                ? 'background:rgba(37,99,235,0.25); color:#93c5fd;' 
                : 'color:#94a3b8;' }}
        " onmouseover="if(!this.classList.contains('active'))this.style.background='rgba(255,255,255,0.05)';this.style.color='#e2e8f0'"
           onmouseout="if(!this.classList.contains('active'))this.style.background='{{ request()->routeIs('dashboard') ? 'rgba(37,99,235,0.25)' : 'transparent' }}';this.style.color='{{ request()->routeIs('dashboard') ? '#93c5fd' : '#94a3b8' }}'">
            <div style="width:16px; text-align:center; flex-shrink:0; font-size:13px;
                {{ request()->routeIs('dashboard') ? 'color:#60a5fa;' : 'color:#475569;' }}">
                <i class="fas fa-chart-pie"></i>
            </div>
            Dashboard
        </a>

        {{-- Data Kendaraan --}}
        <a href="{{ route('parkir.index') }}" style="
            display:flex; align-items:center; gap:10px;
            padding: 9px 10px; border-radius:8px; margin-bottom:2px;
            font-size:13px; font-weight:500; text-decoration:none;
            transition: all 0.15s;
            {{ request()->routeIs('parkir.index') 
                ? 'background:rgba(37,99,235,0.25); color:#93c5fd;' 
                : 'color:#94a3b8;' }}
        ">
            <div style="width:16px; text-align:center; flex-shrink:0; font-size:13px;
                {{ request()->routeIs('parkir.index') ? 'color:#60a5fa;' : 'color:#475569;' }}">
                <i class="fas fa-car"></i>
            </div>
            Data Kendaraan
        </a>

        @if(auth()->user()->role == 'admin')

        {{-- SEPARATOR --}}
        <div style="margin: 14px 0 8px; border-top: 1px solid rgba(255,255,255,0.06); padding-top:12px;">
            <div style="font-size:10px; font-weight:600; color:#334155; text-transform:uppercase; letter-spacing:0.8px; padding: 0 8px; margin-bottom:6px;">
                Manajemen
            </div>
        </div>

        {{-- Data Petugas --}}
        <a href="{{ route('user.index') }}" style="
            display:flex; align-items:center; gap:10px;
            padding: 9px 10px; border-radius:8px; margin-bottom:2px;
            font-size:13px; font-weight:500; text-decoration:none;
            transition: all 0.15s;
            {{ request()->routeIs('user.*') 
                ? 'background:rgba(37,99,235,0.25); color:#93c5fd;' 
                : 'color:#94a3b8;' }}
        ">
            <div style="width:16px; text-align:center; flex-shrink:0; font-size:13px;
                {{ request()->routeIs('user.*') ? 'color:#60a5fa;' : 'color:#475569;' }}">
                <i class="fas fa-users"></i>
            </div>
            Data Petugas
        </a>

        {{-- Atur Tarif --}}
        <a href="{{ route('tarif.index') }}" style="
            display:flex; align-items:center; gap:10px;
            padding: 9px 10px; border-radius:8px; margin-bottom:2px;
            font-size:13px; font-weight:500; text-decoration:none;
            transition: all 0.15s;
            {{ request()->routeIs('tarif.*') 
                ? 'background:rgba(37,99,235,0.25); color:#93c5fd;' 
                : 'color:#94a3b8;' }}
        ">
            <div style="width:16px; text-align:center; flex-shrink:0; font-size:13px;
                {{ request()->routeIs('tarif.*') ? 'color:#60a5fa;' : 'color:#475569;' }}">
                <i class="fas fa-tags"></i>
            </div>
            Atur Tarif
        </a>

        @endif

        {{-- SEPARATOR: OPERASIONAL --}}
        <div style="margin: 14px 0 8px; border-top: 1px solid rgba(255,255,255,0.06); padding-top:12px;">
            <div style="font-size:10px; font-weight:600; color:#334155; text-transform:uppercase; letter-spacing:0.8px; padding: 0 8px; margin-bottom:6px;">
                Operasional
            </div>
        </div>

        {{-- Gerbang Masuk --}}
        <a href="{{ route('masuk.form') }}" target="_blank" style="
            display:flex; align-items:center; gap:10px;
            padding: 9px 10px; border-radius:8px; margin-bottom:2px;
            font-size:13px; font-weight:500; text-decoration:none;
            color:#94a3b8; transition: all 0.15s;
        ">
            <div style="width:16px; text-align:center; flex-shrink:0; font-size:13px; color:#475569;">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            Gerbang Masuk
            <span style="margin-left:auto; font-size:9px; color:#334155;">
                <i class="fas fa-external-link-alt"></i>
            </span>
        </a>

        {{-- Scan Keluar --}}
        <a href="{{ route('parkir.scan') }}" target="_blank" style="
            display:flex; align-items:center; gap:10px;
            padding: 9px 10px; border-radius:8px; margin-bottom:2px;
            font-size:13px; font-weight:500; text-decoration:none;
            color:#94a3b8; transition: all 0.15s;
        ">
            <div style="width:16px; text-align:center; flex-shrink:0; font-size:13px; color:#475569;">
                <i class="fas fa-qrcode"></i>
            </div>
            Scan Keluar
            <span style="margin-left:auto; font-size:9px; color:#334155;">
                <i class="fas fa-external-link-alt"></i>
            </span>
        </a>

    </nav>

    {{-- ===== USER FOOTER ===== --}}
    <div style="padding: 10px; border-top: 1px solid rgba(255,255,255,0.06);">

        {{-- User info --}}
        <div style="
            display:flex; align-items:center; gap:8px;
            padding: 8px 10px; border-radius:8px;
            background: rgba(255,255,255,0.04);
            margin-bottom: 4px;
        ">
            @if(Auth::user()->foto)
                <img src="{{ Storage::url(Auth::user()->foto) }}" alt="{{ Auth::user()->name }}" style="
                    width:28px; height:28px; border-radius:50%; flex-shrink:0; object-fit:cover;
                    border: 1px solid rgba(255,255,255,0.2);
                ">
            @else
                <div style="
                    width:28px; height:28px; border-radius:50%; flex-shrink:0;
                    background: linear-gradient(135deg, #6366f1, #8b5cf6);
                    display:flex; align-items:center; justify-content:center;
                    font-size:11px; font-weight:700; color:white;
                ">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <div style="overflow:hidden;">
                <div style="font-size:12px; font-weight:600; color:#e2e8f0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ Auth::user()->name }}
                </div>
                <div style="font-size:10px; color:#475569;">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>

        {{-- Theme Toggle --}}
        <button id="theme-toggle" type="button" style="
            display:flex; align-items:center; gap:10px; width:100%;
            padding: 8px 10px; border-radius:8px; border:none; cursor:pointer;
            font-size:12px; font-weight:500; background:transparent;
            color:#fbbf24; transition: all 0.15s; margin-bottom:2px;
        ">
            <i id="theme-toggle-icon" class="fas fa-moon" style="width:16px; text-align:center; font-size:12px;"></i>
            <span id="theme-toggle-text">Mode Gelap</span>
        </button>

        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}" style="
            display:flex; align-items:center; gap:10px;
            padding: 8px 10px; border-radius:8px;
            font-size:12px; font-weight:500; text-decoration:none;
            color:#64748b; transition: all 0.15s; margin-bottom:2px;
        ">
            <i class="fas fa-user-cog" style="width:16px; text-align:center; font-size:12px;"></i>
            Pengaturan
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                display:flex; align-items:center; gap:10px; width:100%;
                padding: 8px 10px; border-radius:8px; border:none; cursor:pointer;
                font-size:12px; font-weight:500; background:transparent;
                color:#ef4444; transition: all 0.15s;
            ">
                <i class="fas fa-sign-out-alt" style="width:16px; text-align:center; font-size:12px;"></i>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    var themeToggleBtn = document.getElementById('theme-toggle');
    var themeToggleIcon = document.getElementById('theme-toggle-icon');
    var themeToggleText = document.getElementById('theme-toggle-text');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleIcon.className = 'fas fa-sun';
        themeToggleText.textContent = 'Mode Terang';
        themeToggleBtn.style.color = '#fcd34d';
    } else {
        themeToggleIcon.className = 'fas fa-moon';
        themeToggleText.textContent = 'Mode Gelap';
        themeToggleBtn.style.color = '#94a3b8';
    }

    themeToggleBtn.addEventListener('click', function() {
        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                themeToggleIcon.className = 'fas fa-sun';
                themeToggleText.textContent = 'Mode Terang';
                themeToggleBtn.style.color = '#fcd34d';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                themeToggleIcon.className = 'fas fa-moon';
                themeToggleText.textContent = 'Mode Gelap';
                themeToggleBtn.style.color = '#94a3b8';
            }
        // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                themeToggleIcon.className = 'fas fa-moon';
                themeToggleText.textContent = 'Mode Gelap';
                themeToggleBtn.style.color = '#94a3b8';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                themeToggleIcon.className = 'fas fa-sun';
                themeToggleText.textContent = 'Mode Terang';
                themeToggleBtn.style.color = '#fcd34d';
            }
        }
    });
</script>
