<style>
/* ────────── Navbar ────────── */
.navbar {
    background: #fff;
    border-bottom: 1px solid #dde8de;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(44,62,45,0.06);
}

.navbar-inner {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 60px;
}

/* Brand */
.navbar-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.05rem;
    font-weight: 700;
    color: #3a7347;
    letter-spacing: -0.3px;
    flex-shrink: 0;
}

.navbar-brand img {
    height: 32px;
    width: auto;
    border-radius: 6px;
    object-fit: contain;
}

/* Nav Links (desktop) */
.navbar-links {
    display: flex;
    align-items: center;
    gap: 4px;
}

.nav-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 13px;
    border-radius: 8px;
    font-size: 0.855rem;
    font-weight: 500;
    color: #6b7f6c;
    border: none;
    background: transparent;
    transition: background 0.15s, color 0.15s;
    white-space: nowrap;
}

.nav-link:hover           { background: #f4f9f4; color: #2c3e2d; }
.nav-link.active          { background: #e3f1e5; color: #3a7347; }
.nav-link.nav-logout      { color: #c0392b; border: 1px solid #f5c6c2; margin-left: 6px; }
.nav-link.nav-logout:hover{ background: #fdf3f2; }

/* Hamburger (mobile) */
.nav-hamburger {
    display: none;
    background: transparent;
    border: none;
    font-size: 1.2rem;
    color: #3a7347;
    padding: 6px;
    cursor: pointer;
}

/* Mobile menu */
.navbar-mobile {
    display: none;
    flex-direction: column;
    padding: 10px 16px 14px;
    border-top: 1px solid #e3f1e5;
    gap: 4px;
}

.navbar-mobile .nav-link {
    justify-content: flex-start;
    padding: 9px 12px;
    width: 100%;
    border-radius: 10px;
}

.navbar-mobile .nav-link.nav-logout {
    margin-left: 0;
    margin-top: 4px;
}

.navbar-mobile.open { display: flex; }

/* ────────── Responsive ────────── */
@media (max-width: 640px) {
    .navbar-links    { display: none; }
    .nav-hamburger   { display: block; }
    .navbar-inner    { padding: 0 16px; }
}
</style>

<nav class="navbar">
    <div class="navbar-inner">

        {{-- Brand / Logo --}}
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <span style="
                width:32px; height:32px;
                background:#4a9058;
                border-radius:8px;
                display:inline-flex;
                align-items:center;
                justify-content:center;
                flex-shrink:0;
            ">
                <img src="{{ asset('images/LogoD.png') }}" alt="Dexornit Logo" style="width:22px;height:22px;object-fit:contain;">
            </span>
            Dexornit
        </a>

        {{-- Desktop Nav Links --}}
        <div class="navbar-links">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('pengelolaan') }}"
               class="nav-link {{ request()->routeIs('pengelolaan') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> Pengelolaan
            </a>
            <a href="{{ route('profile') }}"
               class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profil
            </a>

            @if(session('username'))
            <form action="{{ route('logout') }}" method="POST" style="margin:0">
                @csrf
                <button type="submit" class="nav-link nav-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
            @endif
        </div>

        {{-- Hamburger Button (mobile) --}}
        <button class="nav-hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <i class="fas fa-bars" id="hamburgerIcon"></i>
        </button>

    </div>

    {{-- Mobile Dropdown Menu --}}
    <div class="navbar-mobile" id="mobileMenu">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('pengelolaan') }}"
           class="nav-link {{ request()->routeIs('pengelolaan') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i> Pengelolaan
        </a>
        <a href="{{ route('profile') }}"
           class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Profil
        </a>

        @if(session('username'))
        <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="nav-link nav-logout">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
        @endif
    </div>
</nav>

<script>
    const btn  = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');
    const icon = document.getElementById('hamburgerIcon');

    btn.addEventListener('click', () => {
        const open = menu.classList.toggle('open');
        icon.className = open ? 'fas fa-times' : 'fas fa-bars';
    });
</script>
