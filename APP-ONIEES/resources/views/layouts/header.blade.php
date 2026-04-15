<header style="background: #005187; backdrop-filter: blur(16px); border-bottom: 1px solid rgba(77,130,188,0.2); position: sticky; top: 0; z-index: 100; padding: 14px 32px;">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
        <!-- Logo -->
        <a href="{{ url('/') }}" style="display: flex; align-items: center; text-decoration: none;">
            <img src="{{ asset('img/logo-minsa.png') }}" alt="MINSA Logo" style="height: 48px; width: auto; max-width: 190px; object-fit: contain;" onerror="this.style.display='none'">
        </a>
        
        <!-- Navegación -->
        <nav style="display: flex; gap: 12px; flex-wrap: wrap;">
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <form method="POST" action="#" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            @else
                <a href="#" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                @if (Route::has('register'))
                    <a href="#" class="nav-link" style="background: #1E3A5F; color: white;">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                @endif
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
    
    @media (max-width: 640px) {
        header {
            padding: 12px 20px;
        }
        .nav-link {
            padding: 6px 14px;
            font-size: 0.75rem;
        }
    }
</style>