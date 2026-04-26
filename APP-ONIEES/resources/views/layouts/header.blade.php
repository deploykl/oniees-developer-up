<header style="position: sticky; top: 0; z-index: 20; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(6, 182, 212, 0.15); padding: 12px 32px;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
        
       <!-- Logo con efecto glass - OCULTO PARA ADMIN -->
@auth
    @if(!auth()->user()->hasRole('Admin'))
        <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none; background: rgba(255,255,255,0.5); padding: 6px 16px 6px 12px; border-radius: 60px; backdrop-filter: blur(4px); border: 1px solid rgba(6,182,212,0.2); transition: all 0.3s ease;">
            <img src="{{ asset('img/logo-minsa.png') }}" alt="MINSA Logo"
                style="height: 42px; width: auto; max-width: 170px; object-fit: contain;"
                onerror="this.style.display='none'">
        </a>
    @else
        <!-- Admin: espacio vacío para mantener el layout -->
        <div style="width: 170px;"></div>
    @endif
@else
    <!-- Usuarios no autenticados ven el logo -->
    <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none; background: rgba(255,255,255,0.5); padding: 6px 16px 6px 12px; border-radius: 60px; backdrop-filter: blur(4px); border: 1px solid rgba(6,182,212,0.2); transition: all 0.3s ease;">
        <img src="{{ asset('img/logo-minsa.png') }}" alt="MINSA Logo"
            style="height: 42px; width: auto; max-width: 170px; object-fit: contain;"
            onerror="this.style.display='none'">
    </a>
@endauth

        <!-- Navegación GLOBAL para TODOS los usuarios autenticados -->
        <nav style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            @auth
                <!-- DASHBOARD - Visible para todos -->
                <a href="{{ route('dashboard') }}" class="nav-link-glass {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                
                <!-- INFRAESTRUCTURA - Visible para todos -->
                <a href="{{ route('infraestructura.edit') }}" class="nav-link-glass {{ request()->routeIs('infraestructura.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Infraestructura
                </a>

                <!-- Dropdown del usuario con estilo glass -->
                <div class="user-dropdown-glass">
                    <button class="user-menu-btn-glass" onclick="toggleDropdownGlass()">
                        <div class="user-avatar-glass">
                            @if(auth()->user()->profile_photo_url)
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="Avatar">
                            @else
                                <span class="user-initials-glass">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->lastname ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <span class="user-name-glass">
                            {{ auth()->user()->name }} {{ auth()->user()->lastname ?? '' }}
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 12px; margin-left: 8px; transition: transform 0.3s ease;"></i>
                    </button>
                    
                    <div class="dropdown-menu-glass" id="userDropdownGlass">
                        <div class="dropdown-header-glass">
                            <div class="dropdown-user-info-glass">
                                <strong>{{ auth()->user()->name }} {{ auth()->user()->lastname ?? '' }}</strong>
                                <span class="dropdown-user-email-glass">{{ auth()->user()->email }}</span>
                                <span class="dropdown-user-role-glass">
                                    @hasrole('Admin') Administrador
                                    @elseif(auth()->user()->hasRole('Supervisor')) Supervisor
                                    @elseif(auth()->user()->hasRole('Registrador')) Registrador
                                    @elseif(auth()->user()->hasRole('Ipress')) IPRESS
                                    @else Sin rol asignado
                                    @endhasrole
                                </span>
                            </div>
                        </div>
                        <div class="dropdown-divider-glass"></div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-glass">
                            <i class="fas fa-user-circle"></i> Mi Perfil
                        </a>
                        <a href="{{ route('profile.edit') }}#password" class="dropdown-item-glass">
                            <i class="fas fa-key"></i> Cambiar Contraseña
                        </a>
                        <div class="dropdown-divider-glass"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item-glass dropdown-logout-glass">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link-glass">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            @endauth
        </nav>
    </div>
</header>

<style>
    /* Nav links estilo glass */
    .nav-link-glass {
        color: #1E3A5F;
        font-weight: 500;
        padding: 8px 24px;
        border-radius: 60px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.85rem;
        letter-spacing: -0.2px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(8px);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(6, 182, 212, 0.2);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .nav-link-glass i {
        font-size: 0.85rem;
        color: #0E7C9E;
    }

    .nav-link-glass:hover {
        background: linear-gradient(135deg, #1E3A5F, #0F2F47);
        color: white;
        transform: translateY(-2px);
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(30,58,95,0.15);
    }

    .nav-link-glass:hover i {
        color: white;
    }

    /* Estado activo */
    .nav-link-glass.active {
        background: linear-gradient(135deg, #1E3A5F, #0F2F47);
        color: white;
        border-color: transparent;
    }

    .nav-link-glass.active i {
        color: white;
    }

    /* Estilos del menú de usuario glass */
    .user-dropdown-glass {
        position: relative;
        display: inline-block;
    }

    .user-menu-btn-glass {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(6, 182, 212, 0.2);
        padding: 6px 20px 6px 6px;
        border-radius: 60px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.85rem;
        font-weight: 500;
        color: #1E3A5F;
    }

    .user-menu-btn-glass:hover {
        background: linear-gradient(135deg, #1E3A5F, #0F2F47);
        color: white;
        transform: translateY(-2px);
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(30,58,95,0.15);
    }

    .user-menu-btn-glass:hover .user-initials-glass {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    .user-avatar-glass {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, #0E7C9E, #1E3A5F);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .user-avatar-glass img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-initials-glass {
        font-size: 14px;
        font-weight: 600;
        color: white;
        text-transform: uppercase;
    }

    .user-name-glass {
        font-weight: 500;
    }

    /* Dropdown menu glass */
    .dropdown-menu-glass {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08), 0 0 0 1px rgba(6,182,212,0.1);
        min-width: 280px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.98);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
    }

    .dropdown-menu-glass.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .dropdown-header-glass {
        padding: 18px 20px;
        background: linear-gradient(135deg, rgba(14,124,158,0.05), rgba(30,58,95,0.05));
        border-radius: 20px 20px 0 0;
    }

    .dropdown-user-info-glass {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .dropdown-user-info-glass strong {
        color: #1E3A5F;
        font-size: 14px;
    }

    .dropdown-user-email-glass {
        color: #557C8C;
        font-size: 12px;
    }

    .dropdown-user-role-glass {
        background: rgba(14,124,158,0.1);
        color: #0E7C9E;
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
        margin-top: 4px;
        width: fit-content;
    }

    .dropdown-divider-glass {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(6,182,212,0.2), transparent);
        margin: 8px 0;
    }

    .dropdown-item-glass {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: #1E3A5F;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s ease;
        width: 100%;
        background: none;
        border: none;
        cursor: pointer;
    }

    .dropdown-item-glass i {
        width: 20px;
        color: #0E7C9E;
        font-size: 14px;
    }

    .dropdown-item-glass:hover {
        background: rgba(14,124,158,0.08);
        color: #0E7C9E;
    }

    .dropdown-logout-glass {
        color: #DC2626;
    }

    .dropdown-logout-glass i {
        color: #DC2626;
    }

    .dropdown-logout-glass:hover {
        background: rgba(220,38,38,0.08);
        color: #DC2626;
    }

    /* Animación del chevron */
    .user-menu-btn-glass.active i.fa-chevron-down {
        transform: rotate(180deg);
    }

    @media (max-width: 640px) {
        header {
            padding: 10px 16px;
        }
        .nav-link-glass {
            padding: 6px 16px;
            font-size: 0.75rem;
        }
        .user-name-glass {
            display: none;
        }
        .user-menu-btn-glass {
            padding: 6px 10px 6px 6px;
        }
    }
</style>

<script>
    function toggleDropdownGlass() {
        const dropdown = document.getElementById('userDropdownGlass');
        const btn = document.querySelector('.user-menu-btn-glass');
        dropdown.classList.toggle('show');
        btn.classList.toggle('active');
    }

    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdownGlass');
        const btn = document.querySelector('.user-menu-btn-glass');
        if (!btn?.contains(event.target) && !dropdown?.contains(event.target)) {
            dropdown?.classList.remove('show');
            btn?.classList.remove('active');
        }
    });
</script>