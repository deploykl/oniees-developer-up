@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
<div style="position: relative; padding: 40px 24px 80px 24px; text-align: center; overflow-x: clip;">
    <div style="max-width: 1280px; margin: 0 auto;">
        
        <!-- Badge minimal -->
        <div class="badge-glow" style="margin-bottom: 20px;">
            <i class="fas fa-microchip" style="margin-right: 6px;"></i> DIEM · innovación continua
        </div>
        
        <!-- Título principal moderno -->
        <h1 class="hero-title" style="font-size: clamp(32px, 5vw, 44px); font-weight: 700; margin-bottom: 16px; letter-spacing: -0.02em; line-height: 1.2;">
            DIRECCIÓN DE EQUIPAMIENTO Y MANTENIMIENTO <span style="background: linear-gradient(125deg, #226688, #103C51); background-clip: text; -webkit-background-clip: text; color: transparent;">DIEM</span>
        </h1>
        
        <!-- Icono central elegante -->
        <div style="width: 100%; max-width: 200px; margin: 0 auto 16px;">
            <img src="{{ asset('img/icons/observatorio-icono.png') }}" alt="Observatorio" style="width: 100%; opacity: 0.9;" onerror="this.style.display='none'">
        </div>
        
        <!-- Subtítulos con tipografía refinada -->
        <div style="margin: 8px 0 4px;">
            <span style="font-size: clamp(18px, 4vw, 22px); font-weight: 500; color: #163A4F; letter-spacing: -0.3px;">OBSERVATORIO NACIONAL</span>
        </div>
        <p style="font-size: clamp(13px, 3vw, 15px); color: #557C8C; max-width: 620px; margin: 6px auto 0; font-weight: 400; backdrop-filter: blur(2px); padding: 0 16px;">
            <i class="fas fa-chart-simple" style="margin-right: 8px; opacity: 0.7;"></i> Infraestructura y equipamiento de establecimientos de salud
        </p>
    </div>
    
    <!-- Imágenes flotantes: redondas con efectos de transición -->
    <div class="img-container">
        <img src="{{ asset('img/icons/dashboard-1.png') }}" alt="dashboard visual" class="floating-img img-pos-1" onerror="this.style.display='none'">
        <img src="{{ asset('img/icons/dashboard-2.png') }}" alt="métrica" class="floating-img img-pos-2" onerror="this.style.display='none'">
        <img src="{{ asset('img/icons/dashboard-3.png') }}" alt="infraestructura" class="floating-img img-pos-3" onerror="this.style.display='none'">
        <img src="{{ asset('img/icons/dashboard-4.png') }}" alt="equipamiento" class="floating-img img-pos-4" onerror="this.style.display='none'">
    </div>
</div>

<style>
    /* futuristic glassmorphism + micro details */
    .glass-panel {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.6);
        box-shadow: 0 8px 32px rgba(0,0,0,0.02);
    }

    /* gradient borders & modern glow */

    /* floating images – redondas, elegantes con efectos de transición mejorados */
    .floating-img {
        width: 230px;
        height: 230px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        backdrop-filter: blur(4px);
        transition: all 0.5s cubic-bezier(0.34, 1.2, 0.64, 1);
        filter: drop-shadow(0 12px 18px rgba(0,0,0,0.08));
        object-fit: cover;
        cursor: pointer;
        animation: floatInit 0.8s ease-out;
    }
    
    /* Efectos hover mejorados */
    .floating-img:hover {
        transform: translateY(-12px) scale(1.08);
        filter: drop-shadow(0 28px 35px -12px rgba(45,95,126,0.35));
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(2px);
    }
    
    /* Efecto de pulso suave al cargar */
    @keyframes floatInit {
        0% {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    /* Animación flotante continua (sutil) */
    @keyframes subtleFloat {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
    }
    
    /* Animación específica para cada imagen con delay */
    .img-pos-1 {
        position: absolute;
        top: -55%;
        left: 8%;
        animation: subtleFloat 4s ease-in-out infinite;
        animation-delay: 0s;
    }
    
    .img-pos-2 {
        position: absolute;
        top: 8%;
        left: 28%;
        animation: subtleFloat 4.5s ease-in-out infinite;
        animation-delay: 0.5s;
    }
    
    .img-pos-3 {
        position: absolute;
        top: 12%;
        right: 28%;
        animation: subtleFloat 5s ease-in-out infinite;
        animation-delay: 1s;
    }
    
    .img-pos-4 {
        position: absolute;
        top: -52%;
        right: 5%;
        animation: subtleFloat 4.2s ease-in-out infinite;
        animation-delay: 0.3s;
    }

    .img-container {
        position: relative;
        width: 100%;
        height: 200px;
        margin-top: 0px;
    }

    /* modern responsive fluid - corrige distorsión */
    @media (max-width: 1300px) {
        .img-pos-1 { left: 2%; top: -50%; }
        .img-pos-2 { left: 22%; }
        .img-pos-3 { right: 22%; }
        .img-pos-4 { right: 0%; top: -48%; }
        .floating-img { 
            width: 200px;
            height: 200px;
        }
    }

    @media (max-width: 1000px) {
        .img-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            height: auto;
            margin-top: 40px;
            position: static;
        }
        .floating-img {
            position: static !important;
            width: 150px;
            height: 150px;
            animation: floatInit 0.6s ease-out;
        }
        .floating-img:hover {
            transform: translateY(-8px) scale(1.05);
        }
        /* Desactivar animación continua en móvil para mejor rendimiento */
        .img-pos-1, .img-pos-2, .img-pos-3, .img-pos-4 {
            animation: none;
        }
    }

    @media (max-width: 640px) {
        .floating-img { 
            width: 120px;
            height: 120px;
        }
        .img-container {
            gap: 16px;
        }
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

    /* hero title styles */
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
    
    /* responsive para móviles */
    @media (max-width: 768px) {
        .hero-title { 
            font-size: 28px !important; 
        }
        .btn-futuristic, .btn-outline-future {
            padding: 0.7rem 1.5rem;
            font-size: 0.85rem;
        }
    }
    
    /* asegura que las imágenes se vean perfectamente redondas */
    .floating-img {
        object-fit: cover;
        max-width: 100%;
        height: auto;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border: 2px solid rgba(255,255,255,0.8);
    }
    
    /* Efecto de brillo al pasar el mouse */
    .floating-img:hover {
        box-shadow: 0 0 0 4px rgba(77,130,188,0.3), 0 20px 35px -10px rgba(0,0,0,0.2);
    }
</style>

<script>
    (function() {
        // graceful image fallback + console silent
        const images = document.querySelectorAll('.floating-img');
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
                    this.style.transition = 'opacity 0.5s ease';
                    this.style.opacity = '1';
                });
            }
        });
        
        // Agregar efecto de parallax suave en desktop
        if (window.innerWidth > 1000) {
            const container = document.querySelector('.img-container');
            if (container) {
                container.addEventListener('mousemove', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width - 0.5;
                    const y = (e.clientY - rect.top) / rect.height - 0.5;
                    
                    const images = this.querySelectorAll('.floating-img');
                    images.forEach((img, index) => {
                        const speed = 10 + index * 5;
                        const moveX = x * speed;
                        const moveY = y * speed;
                        img.style.transform = `translate(${moveX}px, ${moveY}px)`;
                    });
                });
                
                container.addEventListener('mouseleave', function() {
                    const images = this.querySelectorAll('.floating-img');
                    images.forEach(img => {
                        img.style.transform = '';
                    });
                });
            }
        }
    })();
</script>
@endsection