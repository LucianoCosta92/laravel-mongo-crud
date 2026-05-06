<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'TaskManager' }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #f5f4f0; --surface: #ffffff; --surface2: #f1efe8;
            --border: rgba(0,0,0,0.10); --border-md: rgba(0,0,0,0.18);
            --text: #1a1a18; --text2: #5f5e5a; --text3: #888780;
            --accent: #1D9E75; --accent-light: #E1F5EE; --accent-dark: #0F6E56;
            --danger: #E24B4A; --danger-light: #FCEBEB;
            --warn: #BA7517; --warn-light: #FAEEDA; --info: #378ADD;
            --radius: 10px; --radius-lg: 14px;
        }

        html.dark {
            --bg: #141412; --surface: #1e1e1b; --surface2: #252521;
            --border: rgba(255,255,255,0.07); --border-md: rgba(255,255,255,0.14);
            --text: #e8e6de; --text2: #9e9c94; --text3: #6b6966;
            --accent: #1D9E75; --accent-light: #0d2e22; --accent-dark: #25c490;
            --danger: #e05555; --danger-light: #2a1414;
            --warn: #d4891a; --warn-light: #2a1e08; --info: #4a9de8;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg); color: var(--text); font-size: 14px;
            min-height: 100vh; transition: background .2s, color .2s;
        }

        .app-shell { display: flex; min-height: 100vh; }

        .sidebar {
            width: 220px; min-width: 220px; background: var(--surface);
            border-right: 0.5px solid var(--border);
            display: flex; flex-direction: column; padding: 1.25rem 1rem;
            transition: background .2s;
        }
        .sidebar-logo { font-size: 16px; font-weight: 600; color: var(--accent); margin-bottom: 1.75rem; padding-left: 4px; }
        .nav-item {
            display: flex; align-items: center; gap: 8px; padding: 8px 10px;
            border-radius: var(--radius); color: var(--text2); font-size: 13px;
            font-weight: 500; text-decoration: none; margin-bottom: 2px;
            transition: background .12s, color .12s;
        }
        .nav-item:hover  { background: var(--surface2); color: var(--text); }
        .nav-item.active { background: var(--accent-light); color: var(--accent-dark); }
        .nav-icon { font-size: 15px; width: 18px; text-align: center; }
        .sidebar-bottom { margin-top: auto; }

        /* ── THEME TOGGLE ── */
        .theme-toggle {
            display: flex; align-items: center; justify-content: space-between;
            padding: 7px 10px; border-radius: var(--radius);
            background: var(--surface2); margin-bottom: 8px;
            font-size: 12px; color: var(--text2);
        }
        .toggle-track {
            position: relative; width: 32px; height: 18px;
            background: var(--border-md); border-radius: 9px;
            cursor: pointer; transition: background .2s; flex-shrink: 0;
        }
        .toggle-track.on { background: var(--accent); }
        .toggle-knob {
            position: absolute; top: 2px; left: 2px;
            width: 14px; height: 14px; border-radius: 50%;
            background: #fff; transition: transform .2s;
        }
        .toggle-track.on .toggle-knob { transform: translateX(14px); }

        .user-chip {
            display: flex; align-items: center; gap: 8px; padding: 8px 10px;
            border-radius: var(--radius); background: var(--surface2); margin-bottom: 8px;
        }
        .avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--accent-light); color: var(--accent-dark);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600; flex-shrink: 0;
        }
        .user-name  { font-size: 12px; font-weight: 500; }
        .user-email { font-size: 11px; color: var(--text3); }

        .main { flex: 1; display: flex; flex-direction: column; }
        .topbar {
            background: var(--surface); border-bottom: 0.5px solid var(--border);
            padding: .85rem 1.5rem; display: flex; align-items: center; justify-content: space-between;
            transition: background .2s;
        }
        .topbar-title { font-size: 15px; font-weight: 500; }
        .content { padding: 1.5rem; flex: 1; }

        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: var(--radius);
            border: 0.5px solid var(--border-md); background: var(--surface);
            color: var(--text); font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none; transition: background .15s;
        }
        .btn:hover { background: var(--surface2); }
        .btn.primary { background: var(--accent); color: #fff; border-color: var(--accent-dark); }
        .btn.primary:hover { background: var(--accent-dark); }
        .btn.danger { background: var(--danger-light); color: var(--danger); border-color: var(--danger); }
        .btn.sm { padding: 5px 10px; font-size: 12px; }

        .field { display: flex; flex-direction: column; gap: 5px; margin-bottom: .85rem; }
        .field label { font-size: 12px; color: var(--text2); font-weight: 500; }
        .field input, .field select, .field textarea {
            padding: 8px 10px; border-radius: var(--radius);
            border: 0.5px solid var(--border-md); background: var(--surface);
            color: var(--text); font-size: 14px; outline: none; width: 100%;
            transition: background .2s, border-color .15s;
        }
        .field input:focus, .field select:focus, .field textarea:focus { border-color: var(--accent); }
        .field textarea { resize: vertical; min-height: 72px; }
        .field .error { font-size: 11px; color: var(--danger); margin-top: 2px; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .card {
            background: var(--surface); border-radius: var(--radius);
            border: 0.5px solid var(--border); padding: 1rem; transition: background .2s;
        }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
        .section-header h2 { font-size: 14px; font-weight: 500; }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            text-align: left; font-size: 11px; font-weight: 500; color: var(--text2);
            text-transform: uppercase; letter-spacing: .04em;
            padding: 8px 12px; border-bottom: 0.5px solid var(--border-md);
        }
        tbody tr { border-bottom: 0.5px solid var(--border); }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--surface2); }
        tbody td { padding: 10px 12px; font-size: 13px; vertical-align: middle; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 500; border: 0.5px solid; }
        .badge.pending     { background: #F1EFE8; color: #5f5e5a; border-color: #D3D1C7; }
        .badge.in_progress { background: #E6F1FB; color: #185FA5; border-color: #B5D4F4; }
        .badge.completed   { background: #EAF3DE; color: #3B6D11; border-color: #C0DD97; }
        .badge.canceled    { background: #FCEBEB; color: #A32D2D; border-color: #F7C1C1; }
        .badge.low         { background: #EAF3DE; color: #3B6D11; border-color: #C0DD97; }
        .badge.medium      { background: #FAEEDA; color: #854F0B; border-color: #FAC775; }
        .badge.high        { background: #FCEBEB; color: #A32D2D; border-color: #F7C1C1; }

        html.dark .badge.pending     { background: #2a2925; color: #9e9c94; border-color: #3d3b35; }
        html.dark .badge.in_progress { background: #0e1e30; color: #6aaae8; border-color: #1a3a5c; }
        html.dark .badge.completed   { background: #0e2214; color: #6dc07a; border-color: #1a4023; }
        html.dark .badge.canceled    { background: #2a1414; color: #e07070; border-color: #4a2020; }
        html.dark .badge.low         { background: #0e2214; color: #6dc07a; border-color: #1a4023; }
        html.dark .badge.medium      { background: #2a1e08; color: #d4941a; border-color: #4a3010; }
        html.dark .badge.high        { background: #2a1414; color: #e07070; border-color: #4a2020; }

        .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 1.5rem; }
        .stat-card  { background: var(--surface2); border-radius: var(--radius); padding: .85rem 1rem; }
        .stat-label { font-size: 11px; color: var(--text2); font-weight: 500; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
        .stat-value { font-size: 22px; font-weight: 500; }

        .alert { padding: 10px 14px; border-radius: var(--radius); font-size: 13px; font-weight: 500; margin-bottom: 1rem; border: 0.5px solid; }
        .alert.success { background: var(--accent-light); color: var(--accent-dark); border-color: var(--accent); }
        .alert.error   { background: var(--danger-light); color: var(--danger); border-color: var(--danger); }

        .filters { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 1rem; }
        .filter-link {
            padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500;
            border: 0.5px solid var(--border-md); background: var(--surface);
            color: var(--text2); text-decoration: none; transition: all .12s;
        }
        .filter-link:hover, .filter-link.active { background: var(--accent-light); color: var(--accent-dark); border-color: var(--accent); }

        .cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px,1fr)); gap: 12px; }
        .cat-card  { background: var(--surface); border-radius: var(--radius); border: 0.5px solid var(--border); padding: 1rem; }
        .cat-dot-row { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
        .cat-dot   { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .cat-name  { font-size: 14px; font-weight: 500; }
        .cat-count { font-size: 12px; color: var(--text2); margin-bottom: 10px; }
        .cat-actions { display: flex; gap: 6px; }

        .empty { text-align: center; padding: 3rem 1rem; color: var(--text3); }
        .empty p { font-size: 13px; margin-top: .5rem; }

        input[type="color"] {
            width: 44px; height: 36px; padding: 2px;
            border-radius: var(--radius); border: 0.5px solid var(--border-md); cursor: pointer;
        }
    </style>

    {{-- Aplica o tema ANTES do render para evitar flash de cor errada --}}
    <script>if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');</script>
</head>
<body>
<div class="app-shell">

    <aside class="sidebar">
        <div class="sidebar-logo">TaskManager</div>

        <nav>
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">◈</span> Dashboard
            </a>
            <a href="{{ route('tasks.index') }}"
               class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <span class="nav-icon">☑</span> Tarefas
            </a>
            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <span class="nav-icon">◉</span> Categorias
            </a>
        </nav>

        <div class="sidebar-bottom">

            {{-- Toggle tema escuro/claro --}}
            <div class="theme-toggle">
                <span id="theme-label">Tema claro</span>
                <div class="toggle-track" id="theme-track" onclick="toggleTheme()">
                    <div class="toggle-knob"></div>
                </div>
            </div>

            <div class="user-chip">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn" style="width:100%;font-size:12px">Sair</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">{{ $title ?? 'Dashboard' }}</span>
            {{ $actions ?? '' }}
        </header>
        <div class="content">
            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif
            {{ $slot }}
        </div>
    </div>

</div>

<script>
    // Sincroniza o toggle com o estado salvo
    (function () {
        const isDark = document.documentElement.classList.contains('dark');
        const track  = document.getElementById('theme-track');
        const label  = document.getElementById('theme-label');
        if (isDark) { track.classList.add('on'); label.textContent = 'Tema escuro'; }
    })();

    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        const track  = document.getElementById('theme-track');
        const label  = document.getElementById('theme-label');
        track.classList.toggle('on', isDark);
        label.textContent = isDark ? 'Tema escuro' : 'Tema claro';
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }
</script>
</body>
</html>
