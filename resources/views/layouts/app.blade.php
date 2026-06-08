<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Okul Envanter Takip Sistemi - QR Destekli Kütüphane Yönetim Sistemi">
    <title>{{ config('app.name') }} - @yield('title', 'Ana Sayfa')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{font-family:'Inter',sans-serif;margin:0;padding:0;box-sizing:border-box}
        :root{--bg-primary:#0a0a0f;--bg-secondary:#12121a;--bg-card:#1a1a2e;--bg-card-hover:#222240;--border:#2a2a4a;--text:#e4e4e7;--text-sec:#a1a1aa;--text-muted:#71717a;--accent:#f59e0b;--accent-h:#d97706;--accent-l:rgba(245,158,11,0.1);--success:#10b981;--danger:#ef4444;--info:#3b82f6;--warning:#f59e0b}
        body{background:var(--bg-primary);color:var(--text);min-height:100vh}
        .sidebar{background:var(--bg-secondary);border-right:1px solid var(--border);width:270px;min-height:100vh;position:fixed;left:0;top:0;z-index:50;overflow-y:auto;transition:.3s}
        .sidebar-logo{padding:1.25rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px}
        .logo-icon{width:42px;height:42px;background:linear-gradient(135deg,var(--accent),#ef4444);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem}
        .sidebar-logo h1{font-size:1rem;font-weight:700;background:linear-gradient(135deg,var(--accent),#fbbf24);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .sidebar-logo p{font-size:.65rem;color:var(--text-muted)}
        .nav-section{padding:.5rem 1.25rem;margin-top:.5rem}
        .nav-section-title{font-size:.6rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);font-weight:600}
        .nav-link{display:flex;align-items:center;gap:12px;padding:.65rem 1.25rem;color:var(--text-sec);text-decoration:none;font-size:.825rem;font-weight:500;transition:.2s;border-left:3px solid transparent}
        .nav-link:hover,.nav-link.active{background:var(--accent-l);color:var(--accent);border-left-color:var(--accent)}
        .nav-link i{width:20px;text-align:center}
        .main-content{margin-left:270px;min-height:100vh}
        .top-bar{border-bottom:1px solid var(--border);padding:.75rem 2rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:40;backdrop-filter:blur(20px);background:rgba(18,18,26,0.85)}
        .top-bar h2{font-size:1.2rem;font-weight:700}
        .user-menu{display:flex;align-items:center;gap:10px;padding:.4rem .8rem;background:var(--bg-card);border:1px solid var(--border);border-radius:12px;cursor:pointer;transition:.2s}
        .user-menu:hover{border-color:var(--accent)}
        .user-avatar{width:32px;height:32px;background:linear-gradient(135deg,var(--accent),#ef4444);border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;color:#fff}
        .user-info .name{font-size:.8rem;font-weight:600}
        .user-info .role{font-size:.65rem;color:var(--text-muted)}
        .content-area{padding:2rem}
        .card{background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:1.5rem;transition:.3s}
        .card:hover{border-color:var(--accent);transform:translateY(-2px);box-shadow:0 8px 30px rgba(245,158,11,0.08)}
        .stat-card{background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:1.5rem;position:relative;overflow:hidden;transition:.3s}
        .stat-card:hover{transform:translateY(-4px);box-shadow:0 12px 40px rgba(0,0,0,0.3)}
        .stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin-bottom:1rem}
        .stat-value{font-size:2rem;font-weight:800}
        .stat-label{font-size:.8rem;color:var(--text-muted);margin-top:.25rem}
        .btn{padding:.6rem 1.2rem;border-radius:10px;font-weight:600;font-size:.85rem;border:none;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;gap:8px;text-decoration:none}
        .btn-primary{background:var(--accent);color:#000}
        .btn-primary:hover{background:var(--accent-h);transform:translateY(-1px);box-shadow:0 4px 15px rgba(245,158,11,0.3)}
        .btn-secondary{background:var(--bg-card);color:var(--text);border:1px solid var(--border)}
        .btn-secondary:hover{border-color:var(--accent)}
        .btn-danger{background:rgba(239,68,68,0.15);color:var(--danger);border:1px solid rgba(239,68,68,0.3)}
        .btn-danger:hover{background:var(--danger);color:#fff}
        .btn-success{background:rgba(16,185,129,0.15);color:var(--success);border:1px solid rgba(16,185,129,0.3)}
        .btn-success:hover{background:var(--success);color:#fff}
        .btn-sm{padding:.35rem .7rem;font-size:.75rem;border-radius:8px}
        .form-group{margin-bottom:1.25rem}
        .form-label{display:block;font-size:.8rem;font-weight:600;color:var(--text-sec);margin-bottom:.4rem}
        .form-input,.form-select{width:100%;padding:.7rem 1rem;background:var(--bg-primary);border:1px solid var(--border);border-radius:10px;color:var(--text);font-size:.875rem;outline:none;transition:.2s}
        .form-input:focus,.form-select:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(245,158,11,0.1)}
        .form-error{font-size:.75rem;color:var(--danger);margin-top:.25rem}
        textarea.form-input{min-height:100px;resize:vertical}
        .table-container{background:var(--bg-card);border:1px solid var(--border);border-radius:16px;overflow:hidden}
        .data-table{width:100%;border-collapse:collapse}
        .data-table thead{background:rgba(245,158,11,0.05)}
        .data-table th{padding:.75rem 1rem;text-align:left;font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:var(--text-muted);border-bottom:1px solid var(--border)}
        .data-table td{padding:.75rem 1rem;font-size:.825rem;border-bottom:1px solid rgba(42,42,74,0.5)}
        .data-table tr:hover{background:rgba(245,158,11,0.03)}
        .data-table tr:last-child td{border-bottom:none}
        .badge{padding:.2rem .6rem;border-radius:20px;font-size:.7rem;font-weight:600;display:inline-flex;align-items:center;gap:4px}
        .badge-success{background:rgba(16,185,129,0.15);color:var(--success)}
        .badge-danger{background:rgba(239,68,68,0.15);color:var(--danger)}
        .badge-warning{background:rgba(245,158,11,0.15);color:var(--warning)}
        .badge-info{background:rgba(59,130,246,0.15);color:var(--info)}
        .grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem}
        .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
        .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem}
        .pagination-wrapper{display:flex;justify-content:center;margin-top:1.5rem;gap:4px}
        .pagination-wrapper nav span,.pagination-wrapper nav a{padding:.4rem .8rem;border-radius:8px;font-size:.8rem;border:1px solid var(--border);color:var(--text-sec);text-decoration:none;background:var(--bg-card)}
        .pagination-wrapper nav span[aria-current]{background:var(--accent);color:#000;border-color:var(--accent)}
        .pagination-wrapper nav a:hover{border-color:var(--accent);color:var(--accent)}
        .search-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1.5rem}
        .search-input-wrapper{position:relative;flex:1;min-width:200px}
        .search-input-wrapper i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted)}
        .search-input-wrapper input{width:100%;padding:.7rem 1rem .7rem 2.5rem;background:var(--bg-card);border:1px solid var(--border);border-radius:10px;color:var(--text);font-size:.85rem;outline:none}
        .search-input-wrapper input:focus{border-color:var(--accent)}
        .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem}
        .page-header h1{font-size:1.5rem;font-weight:800}
        .page-header p{font-size:.85rem;color:var(--text-muted);margin-top:.25rem}
        .empty-state{text-align:center;padding:3rem;color:var(--text-muted)}
        .empty-state i{font-size:3rem;margin-bottom:1rem;display:block}
        .mobile-toggle{display:none;background:none;border:none;color:var(--text);font-size:1.3rem;cursor:pointer}
        .dropdown{position:relative}
        .dropdown-menu{display:none;position:absolute;right:0;top:100%;margin-top:.5rem;background:var(--bg-card);border:1px solid var(--border);border-radius:12px;min-width:180px;padding:.5rem;z-index:100;box-shadow:0 10px 40px rgba(0,0,0,0.4)}
        .dropdown-menu.show{display:block}
        .dropdown-item{display:flex;align-items:center;gap:8px;padding:.5rem .75rem;font-size:.8rem;color:var(--text-sec);text-decoration:none;border-radius:8px;transition:.2s;background:none;border:none;cursor:pointer;width:100%}
        .dropdown-item:hover{background:var(--accent-l);color:var(--accent)}
        .dropdown-divider{border-top:1px solid var(--border);margin:.25rem 0}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .animate-in{animation:fadeInUp .5s ease forwards;opacity:0}
        .delay-1{animation-delay:.1s}.delay-2{animation-delay:.2s}.delay-3{animation-delay:.3s}.delay-4{animation-delay:.4s}
        ::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:var(--bg-primary)}::-webkit-scrollbar-thumb{background:var(--border);border-radius:3px}::-webkit-scrollbar-thumb:hover{background:var(--accent)}
        @media(max-width:768px){.sidebar{transform:translateX(-100%)}.sidebar.open{transform:translateX(0)}.main-content{margin-left:0}.mobile-toggle{display:block}.grid-4{grid-template-columns:repeat(2,1fr)}.grid-3,.grid-2{grid-template-columns:1fr}.content-area{padding:1rem}.top-bar{padding:.75rem 1rem}}
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">🏫</div>
            <div>
                <h1>Okul Envanter</h1>
                <p>Kütüphane Yönetim Sistemi</p>
            </div>
        </div>
        <nav>
            <div class="nav-section"><div class="nav-section-title">Ana Menü</div></div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Dashboard</a>
            @if(auth()->user()->isAdmin())
            <div class="nav-section"><div class="nav-section-title">Yönetim</div></div>
            <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.index','books.create','books.edit','books.show') ? 'active' : '' }}"><i class="fas fa-book"></i> Kitaplar</a>
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"><i class="fas fa-folder"></i> Kategoriler</a>
            <a href="{{ route('loans.index') }}" class="nav-link {{ request()->routeIs('loans.index','loans.create') ? 'active' : '' }}"><i class="fas fa-exchange-alt"></i> Ödünç İşlemleri</a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Kullanıcılar</a>
            <a href="{{ route('books.trashed') }}" class="nav-link {{ request()->routeIs('books.trashed') ? 'active' : '' }}"><i class="fas fa-trash-alt"></i> Arşiv</a>
            @endif
            <div class="nav-section"><div class="nav-section-title">Kütüphane</div></div>
            <a href="{{ route('books.catalog') }}" class="nav-link {{ request()->routeIs('books.catalog') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Katalog</a>
            <a href="{{ route('loans.my') }}" class="nav-link {{ request()->routeIs('loans.my') ? 'active' : '' }}"><i class="fas fa-bookmark"></i> Ödünçlerim</a>
            <a href="{{ route('qr.scan') }}" class="nav-link {{ request()->routeIs('qr.scan') ? 'active' : '' }}"><i class="fas fa-qrcode"></i> QR Tara</a>
            <div class="nav-section"><div class="nav-section-title">Hesap</div></div>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="fas fa-user-cog"></i> Profil</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nav-link" style="width:100%;background:none;border:none;text-align:left;cursor:pointer;color:var(--text-sec)"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</button></form>
        </nav>
    </aside>

    <div class="main-content">
        <header class="top-bar">
            <div style="display:flex;align-items:center;gap:1rem">
                <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')"><i class="fas fa-bars"></i></button>
                <h2>@yield('title', 'Dashboard')</h2>
            </div>
            <div class="dropdown">
                <div class="user-menu" onclick="this.parentElement.querySelector('.dropdown-menu').classList.toggle('show')">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <div class="user-info">
                        <div class="name">{{ auth()->user()->name }}</div>
                        <div class="role">{{ auth()->user()->isAdmin() ? '👑 Yönetici' : '🎓 Öğrenci' }}</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size:.7rem;color:var(--text-muted)"></i>
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="fas fa-user"></i> Profil</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</button></form>
                </div>
            </div>
        </header>
        <main class="content-area">@yield('content')</main>
    </div>

    <script>
        document.addEventListener('click',e=>{document.querySelectorAll('.dropdown-menu.show').forEach(m=>{if(!m.parentElement.contains(e.target))m.classList.remove('show')})});
        @if(session('success'))
        Swal.fire({icon:'success',title:'Başarılı!',text:'{{ session("success") }}',background:'#1a1a2e',color:'#e4e4e7',confirmButtonColor:'#f59e0b',timer:3000,timerProgressBar:true});
        @endif
        @if(session('error'))
        Swal.fire({icon:'error',title:'Hata!',text:'{{ session("error") }}',background:'#1a1a2e',color:'#e4e4e7',confirmButtonColor:'#ef4444'});
        @endif
    </script>
    @stack('scripts')
</body>
</html>
