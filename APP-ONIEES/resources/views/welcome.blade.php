<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <title>{{ config('app.name', 'ONIEES') }}</title>
    <meta name="description" content="Sistema de monitoreo de infraestructura y equipamiento de establecimientos de salud — DIEM MINSA Perú">
    
    <!-- Font Awesome 6 (Sharp & Clean) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicon.png') }}">
    <!-- Google Fonts: Inter + Space Grotesk (futuristic minimal) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F6F9FE;
            color: #0A1A2F;
            scroll-behavior: smooth;
        }

        /* futuristic glassmorphism + micro details */
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 8px 32px rgba(0,0,0,0.02);
        }

        /* gradient borders & modern glow */
        .futuristic-glow {
            background: radial-gradient(circle at 20% 30%, rgba(77,130,188,0.08) 0%, rgba(15,42,58,0.02) 80%);
        }

        /* floating images – refined, more elegant, lighter hover */
        .floating-img {
            width: 230px;
            height: auto;
            border-radius: 48% 52% 44% 56% / 38% 44% 56% 62%;
            background: rgba(255,255,255,0.3);
            backdrop-filter: blur(2px);
            transition: all 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.2);
            filter: drop-shadow(0 12px 18px rgba(0,0,0,0.03));
            object-fit: contain;
        }

        .floating-img:hover {
            transform: translateY(-6px) scale(1.02);
            filter: drop-shadow(0 24px 28px rgba(45,95,126,0.12));
        }

        /* positioning : higher & airy */
        .img-pos-1 { position: absolute; top: -55%; left: 8%; }
        .img-pos-2 { position: absolute; top: 8%; left: 28%; }
        .img-pos-3 { position: absolute; top: 12%; right: 28%; }
        .img-pos-4 { position: absolute; top: -52%; right: 5%; }

        .img-container {
            position: relative;
            width: 100%;
            height: 280px;
            margin-top: -20px;
        }

        /* modern responsive fluid */
        @media (max-width: 1300px) {
            .img-pos-1 { left: 2%; top: -50%; }
            .img-pos-2 { left: 24%; }
            .img-pos-3 { right: 24%; }
            .img-pos-4 { right: 0%; top: -48%; }
            .floating-img { width: 200px; }
        }

        @media (max-width: 1000px) {
            .img-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 28px;
                height: auto;
                margin-top: 40px;
                position: static;
            }
            .floating-img {
                position: static !important;
                width: 170px;
                border-radius: 40px;
            }
        }

        @media (max-width: 640px) {
            .floating-img { width: 130px; }
        }

        /* primary button – sleek & futuristic */
        .btn-futuristic {
            background: linear-gradient(105deg, #1E3A5F 0%, #0F2F47 100%);
            color: white;
            padding: 0.85rem 2rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: -0.2px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(15, 47, 71, 0.12);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            text-decoration: none;
            backdrop-filter: blur(2px);
        }

        .btn-futuristic:hover {
            transform: translateY(-2px);
            background: linear-gradient(105deg, #143250 0%, #092336 100%);
            box-shadow: 0 12px 22px -8px rgba(30,58,95,0.28);
        }

        .btn-outline-future {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(45,95,126,0.35);
            color: #1F4E6E;
            padding: 0.85rem 2rem;
            border-radius: 60px;
            font-weight: 500;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-outline-future:hover {
            background: #1E3A5F;
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.05);
        }

        /* header minimalist + blur future */
        .future-header {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(77,130,188,0.2);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 14px 32px;
        }

        /* links minimal */
        .nav-link-future {
            color: #1E3A5F;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 40px;
            transition: all 0.2s;
            font-size: 0.85rem;
            letter-spacing: -0.2px;
            background: rgba(77,130,188,0.05);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link-future i { font-size: 0.85rem; }
        .nav-link-future:hover {
            background: #1E3A5F;
            color: white;
            transform: scale(0.98);
        }

        .footer-minimal {
            background: #F9FCFE;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .footer-link-light {
            color: #4B5565;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 450;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .footer-link-light:hover { color: #1E3A5F; transform: translateX(3px); }

        /* micro animations */
        @keyframes softRise {
            0% { opacity: 0; transform: translateY(12px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .animate-soft { animation: softRise 0.7s ease forwards; }
        
        .hero-title {
            font-family: 'Space Grotesk', monospace;
            font-weight: 600;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #132F42 0%, #31637E 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        
        .badge-glow {
            background: rgba(77,130,188,0.12);
            backdrop-filter: blur(4px);
            border-radius: 80px;
            padding: 4px 14px;
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            color: #205072;
        }
        
        @media (max-width: 768px) {
            .future-header { padding: 12px 20px; }
            .hero-title { font-size: 28px; }
        }
    </style>
</head>
<body>

    <!-- Header ultra clean + futurista -->
    <header class="future-header">
        <div style="max-width: 1400px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;">
            <a class="navbar-brand" href="#" style="display: flex; align-items: center;">
                <img src="{{ asset('img/logo-minsa.png') }}" style="height: 48px; width: auto; max-width: 190px; object-fit: contain;" alt="MINSA Logo" onerror="this.style.display='none'">
            </a>
            
            <nav style="display: flex; gap: 12px;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link-future">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                @else
                    <a href="#" class="nav-link-future">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="#" class="nav-link-future" style="background: #1E3A5F; color: white;">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero section - moderno + futurista, elegante y contenido compacto -->
    <div class="futuristic-glow" style="position: relative; padding: 40px 24px 80px 24px; text-align: center; overflow-x: clip;">
        <div style="max-width: 1280px; margin: 0 auto;">
            
            <!-- Etiqueta minimal -->
            <div class="badge-glow" style="margin-bottom: 20px;">
                <i class="fas fa-microchip" style="margin-right: 6px;"></i> DIEM · innovación continua
            </div>
            
            <!-- Título principal moderno -->
            <h1 class="hero-title" style="font-size: 44px; font-weight: 700; margin-bottom: 16px; letter-spacing: -0.02em; line-height: 1.2;">
                DIRECCIÓN DE EQUIPAMIENTO<br>Y MANTENIMIENTO <span style="background: linear-gradient(125deg, #226688, #103C51); background-clip: text; -webkit-background-clip: text; color: transparent;">DIEM</span>
            </h1>
            
            <!-- Icono central elegante -->
            <div style="width: 100%; max-width: 180px; margin: 0 auto 16px;">
                @if(isset($webpage) && $webpage->imagen)
                    <img src="{{ asset($webpage->imagen) }}" alt="Observatorio" style="width: 100%; opacity: 0.9;" onerror="this.style.display='none'">
                @else
                    <img src="{{ asset('img/icons/observatorio-icono.png') }}" alt="Observatorio" style="width: 100%;" onerror="this.style.display='none'">
                @endif
            </div>
            
            <!-- Subtítulos con tipografía refinada -->
            <div style="margin: 8px 0 4px;">
                <span style="font-size: 22px; font-weight: 500; color: #163A4F; letter-spacing: -0.3px;">OBSERVATORIO NACIONAL</span>
            </div>
            <p style="font-size: 15px; color: #557C8C; max-width: 620px; margin: 6px auto 0; font-weight: 400; backdrop-filter: blur(2px);">
                <i class="fas fa-chart-simple" style="margin-right: 8px; opacity: 0.7;"></i> Infraestructura y equipamiento de establecimientos de salud
            </p>
            
            <!-- CTA sutiles (opcional, sin saturar) -->
            <div style="margin-top: 32px; display: flex; gap: 18px; justify-content: center; flex-wrap: wrap;">
                <a href="#" class="btn-futuristic"><i class="fas fa-chart-line"></i> Explorar indicadores</a>
                <a href="#" class="btn-outline-future"><i class="fas fa-map-marked-alt"></i> Mapa de equipamiento</a>
            </div>
        </div>
        
        <!-- Imágenes flotantes: más livianas, elegantes y futuristas -->
        <div class="img-container">
            <img src="{{ asset('img/icons/dashboard-1.png') }}" alt="dashboard visual" class="floating-img img-pos-1" onerror="this.style.display='none'">
            <img src="{{ asset('img/icons/dashboard-2.png') }}" alt="métrica" class="floating-img img-pos-2" onerror="this.style.display='none'">
            <img src="{{ asset('img/icons/dashboard-3.png') }}" alt="infraestructura" class="floating-img img-pos-3" onerror="this.style.display='none'">
            <img src="{{ asset('img/icons/dashboard-4.png') }}" alt="equipamiento" class="floating-img img-pos-4" onerror="this.style.display='none'">
        </div>
    </div>

    <!-- Footer futurista minimal con detalles brillantes -->
    <footer class="footer-minimal" style="padding: 48px 30px 32px;">
        <div style="max-width: 1280px; margin: 0 auto;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 28px; margin-bottom: 36px;">
                <div style="display: flex; flex-wrap: wrap; gap: 32px;">
                    @if(env('CELULAR_SOPORTE_1', ''))
                        <a href="tel:+51{{ env('CELULAR_SOPORTE_1') }}" class="footer-link-light">
                            <i class="fas fa-phone-alt" style="font-size: 12px;"></i> {{ env('CELULAR_SOPORTE_1') }} · {{ env('SOPORTE_1', 'Soporte') }}
                        </a>
                    @endif
                    @if(env('CELULAR_SOPORTE_2', ''))
                        <a href="tel:+51{{ env('CELULAR_SOPORTE_2') }}" class="footer-link-light">
                            <i class="fas fa-phone-alt"></i> {{ env('CELULAR_SOPORTE_2') }} · {{ env('SOPORTE_2', 'Soporte') }}
                        </a>
                    @endif
                    @if(env('CORREO_SOPORTE', ''))
                        <a href="mailto:{{ env('CORREO_SOPORTE') }}" class="footer-link-light">
                            <i class="fas fa-paper-plane"></i> {{ env('CORREO_SOPORTE') }}
                        </a>
                    @endif
                </div>
                
                @if(env('FRASE', ''))
                    <div style="display: flex; align-items: center; gap: 14px; background: rgba(77,130,188,0.04); padding: 6px 16px; border-radius: 80px;">
                        <img src="{{ asset('img/icons/salud.jpg') }}" alt="MINSA emblem" style="height: 34px; object-fit: contain; border-radius: 12px;" onerror="this.style.display='none'">
                        <p style="color: #2C6279; font-size: 12px; font-weight: 450; max-width: 360px; margin: 0; line-height: 1.4;">{{ env('FRASE') }}</p>
                    </div>
                @endif
            </div>
            
            <div style="border-top: 1px solid #E2E9F0; padding-top: 28px; text-align: center; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 12px;">
                <p style="color: #8A9EB0; font-size: 12px; margin: 0;">© {{ date('Y') }} DIEM · Dirección de Equipamiento y Mantenimiento. MINSA Perú.</p>
                <div style="display: flex; gap: 20px;">
                    <span style="color: #B9CAD9; font-size: 11px;"><i class="far fa-heart"></i> datos abiertos</span>
                    <span style="color: #B9CAD9; font-size: 11px;"><i class="fas fa-chart-network"></i> observatorio nacional</span>
                </div>
            </div>
            <p style="color: #9BB0C2; font-size: 11px; text-align: center; margin-top: 18px;">Sistema integrado de infraestructura y equipamiento · transparencia y eficiencia</p>
        </div>
    </footer>

    <script>
        (function() {
            // graceful image fallback + console silent
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('error', function(e) {
                    console.debug('img not loaded (optional):', this.src);
                    this.style.opacity = '0';
                    this.style.display = 'none';
                });
                // futuristic fade-in effect for images when loaded
                if (img.complete && img.naturalHeight !== 0) {
                    img.style.opacity = '1';
                } else {
                    img.style.opacity = '0';
                    img.addEventListener('load', function() {
                        this.style.transition = 'opacity 0.4s';
                        this.style.opacity = '1';
                    });
                }
            });
        })();
    </script>
</body>
</html>