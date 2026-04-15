<header style="background: #005187; backdrop-filter: blur(16px); border-bottom: 1px solid rgba(77,130,188,0.2); position: sticky; top: 0; z-index: 100; padding: 14px 32px;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
        <!-- Logo -->
        <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
            <img src="{{ asset('img/logo-minsa.png') }}" alt="MINSA Logo"
                style="height: 48px; width: auto; max-width: 190px; object-fit: contain;"
                onerror="this.style.display='none'">
        </a>

        <!-- Navegación -->
        <nav style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                
                <!-- Dropdown del usuario -->
                <div class="user-dropdown">
                    <button class="user-menu-btn" onclick="toggleDropdown()">
                        <div class="user-avatar">
                            @if(auth()->user()->profile_photo_url)
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="Avatar">
                            @else
                                <span class="user-initials">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->lastname ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <span class="user-name">
                            {{ auth()->user()->name }} {{ auth()->user()->lastname ?? '' }}
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 12px; margin-left: 8px;"></i>
                    </button>
                    
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="dropdown-header">
                            <div class="dropdown-user-info">
                                <strong>{{ auth()->user()->name }} {{ auth()->user()->lastname ?? '' }}</strong>
                                <span class="dropdown-user-email">{{ auth()->user()->email }}</span>
                                @if(auth()->user()->cargo)
                                    <span class="dropdown-user-role">{{ auth()->user()->cargo }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user-circle"></i> Mi Perfil
                        </a>
                        <a href="{{ route('profile.edit') }}#password" class="dropdown-item">
                            <i class="fas fa-key"></i> Cambiar Contraseña
                        </a>
                      
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-logout">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            @endauth
        </nav>
    </div>
</header>

<style>
    .nav-link {
        color: #005187;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 40px;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        letter-spacing: -0.2px;
        background: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .nav-link i {
        font-size: 0.85rem;
    }

    .nav-link:hover {
        background: #1E3A5F;
        color: white;
        transform: translateY(-1px);
    }

    /* Estilos del menú de usuario */
    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .user-menu-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        border: none;
        padding: 6px 16px 6px 6px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.85rem;
        font-weight: 500;
        color: #005187;
    }

    .user-menu-btn:hover {
        background: #1E3A5F;
        color: white;
        transform: translateY(-1px);
    }

    .user-menu-btn:hover .user-initials {
        background: #2D5F7E;
        color: white;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, #1E3A5F, #0F2F47);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-initials {
        font-size: 14px;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
    }

    .user-name {
        font-weight: 500;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        min-width: 260px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        z-index: 1000;
    }

    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-header {
        padding: 16px;
    }

    .dropdown-user-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .dropdown-user-info strong {
        color: #1E3A5F;
        font-size: 14px;
    }

    .dropdown-user-email {
        color: #557C8C;
        font-size: 12px;
    }

    .dropdown-user-role {
        background: #E8F4F8;
        color: #2D5F7E;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 500;
        display: inline-block;
        margin-top: 4px;
    }

    .dropdown-divider {
        height: 1px;
        background: #E2E8F0;
        margin: 8px 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        color: #1E3A5F;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s ease;
        width: 100%;
        background: none;
        border: none;
        cursor: pointer;
    }

    .dropdown-item i {
        width: 20px;
        color: #2D5F7E;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background: #F0F4F8;
        color: #005187;
    }

    .dropdown-logout {
        color: #DC2626;
    }

    .dropdown-logout i {
        color: #DC2626;
    }

    .dropdown-logout:hover {
        background: #FEE2E2;
        color: #DC2626;
    }

    @media (max-width: 640px) {
        header {
            padding: 12px 20px;
        }
        .nav-link {
            padding: 6px 14px;
            font-size: 0.75rem;
        }
        .user-name {
            display: none;
        }
        .user-menu-btn {
            padding: 6px 6px;
        }
    }
</style>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('show');
    }

    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const btn = document.querySelector('.user-menu-btn');
        if (!btn?.contains(event.target) && !dropdown?.contains(event.target)) {
            dropdown?.classList.remove('show');
        }
    });
</script>