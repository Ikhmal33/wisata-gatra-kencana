<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Gatra Kencana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream:   '#F9F9F5',
                        eg:      { DEFAULT: '#2A9D6F', light: '#3ab882', dark: '#1e7352', muted: 'rgba(42,157,111,0.12)' },
                        gold:    { DEFAULT: '#EAA83A', muted: 'rgba(234,168,58,0.12)' },
                        forest:  '#1E2522',
                        ch:      '#2D312E',
                        muted:   '#707771',
                    },
                    fontFamily: {
                        serif: ['"DM Serif Display"','Georgia','serif'],
                        sans:  ['"DM Sans"','system-ui','sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --c-bg:      #FFFFFF;
            --c-alt:     #F9F9F5;
            --c-eg:      #2A9D6F;
            --c-gold:    #EAA83A;
            --c-forest:  #1E2522;
            --c-body:    #2D312E;
            --c-muted:   #707771;
            --sidebar-w: 248px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--c-alt);
            color: var(--c-body);
            -webkit-font-smoothing: antialiased;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--c-forest);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar::-webkit-scrollbar { width: 0; }

        @media (max-width: 1023px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); box-shadow: 0 0 60px rgba(0,0,0,0.3); }
            .main-wrap { margin-left: 0 !important; }
        }

        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Sidebar logo area ── */
        .sidebar-header {
            padding: 24px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        /* ── Sidebar nav ── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            margin: 2px 12px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
            cursor: pointer;
        }
        .nav-item:hover {
            color: rgba(255,255,255,0.85);
            background: rgba(255,255,255,0.06);
        }
        .nav-item.active {
            color: white;
            background: rgba(42,157,111,0.2);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%; transform: translateY(-50%);
            width: 3px; height: 18px;
            background: var(--c-eg);
            border-radius: 0 3px 3px 0;
        }
        .nav-item .icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            background: rgba(255,255,255,0.06);
            flex-shrink: 0;
            transition: background 0.2s;
        }
        .nav-item.active .icon {
            background: rgba(42,157,111,0.25);
        }
        .nav-item.danger { color: rgba(239,68,68,0.7); }
        .nav-item.danger:hover { color: #f87171; background: rgba(239,68,68,0.08); }

        /* ── Main content area ── */
        .page-content {
            flex: 1;
            padding: 24px;
            max-width: 900px;
        }

        /* ── Top bar (mobile) ── */
        .topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            background: var(--c-forest);
            position: sticky;
            top: 0;
            z-index: 40;
        }
        @media (max-width: 1023px) {
            .topbar { display: flex; }
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            animation: slideInRight 0.35s cubic-bezier(0.16,1,0.3,1);
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 340px;
        }
        .toast-success { background: white; border-left: 4px solid var(--c-eg); color: var(--c-forest); }
        .toast-error   { background: white; border-left: 4px solid #ef4444; color: var(--c-forest); }
        @keyframes slideInRight {
            from { transform: translateX(110%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        /* ── Overlay (mobile sidebar) ── */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 49;
            backdrop-filter: blur(4px);
        }
    </style>

    @stack('head')
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- ══════════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════════ -->
<aside class="sidebar" id="sidebar">

    <!-- Header: Logo -->
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            <div style="width:40px;height:40px;border-radius:10px;overflow:hidden;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <img src="{{ asset('assets/logo-gatrakencana.jpg') }}" alt="Logo Gatra Kencana" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div>
                <p style="font-family:'DM Serif Display',serif;font-size:0.9rem;color:white;line-height:1.1;">Gatra Kencana</p>
                <p style="font-size:0.65rem;color:rgba(255,255,255,0.35);margin-top:1px;letter-spacing:0.04em;">Admin dan Penjualan</p>
            </div>
        </a>
    </div>

    <!-- Cashier Profile Card -->
    <div style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.06);">
        <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:14px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:38px;height:38px;background:linear-gradient(135deg,rgba(42,157,111,0.4),rgba(42,157,111,0.1));border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                    @php
                    $booth = auth()->user()->assigned_booth;
                    $emoji = match($booth) { 'loket_masuk' => '🎟️', 'kolam_renang' => '🏊', 'kelinci' => '🐰', default => (auth()->user()->isAdmin() ? '👑' : '📝') };
                    @endphp
                    {{ $emoji }}
                </div>
                <div style="min-width:0;">
                    <p style="font-size:0.875rem;font-weight:600;color:white;line-height:1.2;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->name }}</p>
                    <p style="font-size:0.7rem;color:rgba(255,255,255,0.4);margin-top:1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->booth_label }}</p>
                </div>
            </div>
            <div style="margin-top:10px;">
                @php
                $bc = $booth === 'loket_masuk' ? ['#2A9D6F','rgba(42,157,111,0.15)'] : ($booth === 'kolam_renang' ? ['#3b82f6','rgba(59,130,246,0.15)'] : ['#EAA83A','rgba(234,168,58,0.15)']);
                @endphp
                <span style="display:inline-block;background:{{ $bc[1] }};color:{{ $bc[0] }};font-size:0.68rem;font-weight:600;padding:3px 10px;border-radius:100px;letter-spacing:0.05em;text-transform:uppercase;">
                    {{ auth()->user()->booth_label }}
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav style="padding:12px 0;flex:1;overflow-y:auto;">
        {{-- ── Finance module: only admin + cashier ── --}}
        @if(auth()->user()->hasFinanceAccess())
            <p style="padding:8px 28px;font-size:0.62rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.25);">Kasir & Laporan</p>

            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') && !request()->has('mode') ? 'active' : '' }}">
                <div class="icon">🎟️</div>
                <span>Jual Tiket (POS)</span>
            </a>

            {{-- Mode Lebaran — Hanya untuk loket_masuk atau Admin --}}
            @if(auth()->user()->assigned_booth === 'loket_masuk' || auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}?mode=lebaran" class="nav-item {{ request()->get('mode')==='lebaran' ? 'active' : '' }}"
                   style="{{ request()->get('mode')==='lebaran' ? '' : 'color:rgba(255,153,51,0.7);' }}">
                    <div class="icon" style="background:rgba(234,168,58,0.15);">🌙</div>
                    <span>Mode Lebaran</span>
                </a>
            @endif

            <a href="{{ route('admin.rekapan') }}" class="nav-item {{ request()->routeIs('admin.rekapan') ? 'active' : '' }}">
                <div class="icon">📊</div>
                <span>Rekapan Harian</span>
            </a>

            {{-- Rekapan Bulanan: Khusus Admin --}}
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.rekapan.bulanan') }}" class="nav-item {{ request()->routeIs('admin.rekapan.bulanan') ? 'active' : '' }}">
                    <div class="icon">📅</div>
                    <span>Rekapan Bulanan</span>
                </a>
            @endif

            <a href="{{ route('admin.kas') }}" class="nav-item {{ request()->routeIs('admin.kas') ? 'active' : '' }}">
                <div class="icon">💰</div>
                <span>Buku Kas</span>
            </a>
        @endif

        {{-- ── News module: admin + content_admin ── --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isContentAdmin())
            <p style="padding:14px 28px 8px;font-size:0.62rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.25);">Konten Publik</p>
            <a href="{{ route('admin.news.index') }}" class="nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <div class="icon">📰</div>
                <span>Kelola Berita</span>
            </a>
        @endif
    </nav>

    <!-- Footer: logout -->
    <div style="padding:16px 12px 20px;border-top:1px solid rgba(255,255,255,0.06); flex-shrink:0;">
        <a href="{{ route('home') }}" class="nav-item" style="margin-bottom:4px;">
            <div class="icon">🌿</div>
            <span>Lihat Website</span>
        </a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-item danger" style="width:100%;border:none;background:none;text-align:left;">
                <div class="icon" style="background:rgba(239,68,68,0.1);">🚪</div>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<!-- ══════════════════════════════════════════════════
     MAIN WRAP
══════════════════════════════════════════════════ -->
<div class="main-wrap">

    <!-- Mobile Topbar -->
    <div class="topbar">
        <button onclick="openSidebar()" style="background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;">
            <svg width="22" height="22" fill="none" stroke="rgba(255,255,255,0.8)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <p style="font-family:'DM Serif Display',serif;font-size:0.9rem;color:white;">Gatra Kencana</p>
        <div style="width:30px;height:30px;background:rgba(42,157,111,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;">
            {{ $emoji }}
        </div>
    </div>

    <!-- Page content -->
    <main class="page-content" style="max-width: none;">
        @yield('content')
    </main>

</div>

<!-- ══════════════════════════════════════════════════
     TOAST NOTIFICATIONS
══════════════════════════════════════════════════ -->
@if(session('success'))
<div class="toast toast-success" id="toast-el">
    <svg width="18" height="18" fill="none" stroke="var(--c-eg)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="toast toast-error" id="toast-el">
    <svg width="18" height="18" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ $errors->first() }}
</div>
@endif

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').style.display = 'block';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').style.display = 'none';
    }

    // Auto-dismiss toast
    const toast = document.getElementById('toast-el');
    if (toast) {
        setTimeout(() => {
            toast.style.transition = 'all 0.4s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(110%)';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }
</script>

@stack('scripts')
</body>
</html>