<footer class="footer-glass">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
            
            <!-- Sección DIEM -->
            <div class="footer-section">
                <div class="footer-title">
                    <i class="fas fa-microchip"></i>
                    DIEM - ONIEES
                </div>
                <div class="footer-contact-list">
                    <p>
                        <i class="fas fa-phone-alt"></i>
                        <span>315-6600 - Anexo 5106</span>
                    </p>
                    <p>
                        <i class="fas fa-envelope"></i>
                        <span>soporteoniees@minsa.gob.pe</span>
                    </p>
                    <p>
                        <i class="fas fa-globe"></i>
                        <span>oniees.minsa.gob.pe</span>
                    </p>
                </div>
            </div>
            
            <!-- Sección Enlaces rápidos -->
            <div class="footer-section">
                <div class="footer-title">
                    <i class="fas fa-link"></i>
                    Enlaces de interés
                </div>
                <div class="footer-links">
                    <a href="{{ route('repositorio.index') }}"><i class="fas fa-chart-line"></i> Repositorio</a>
                    <a href="#"><i class="fas fa-database"></i> Infraestructura</a>
                    <a href="#"><i class="fas fa-file-alt"></i> Equipamiento</a>
                    <a href="#"><i class="fas fa-headset"></i> Mantenimiento</a>
                    <a href="https://dbdiagram.io/d/69f6479dc6a36f9c1be49ee4"><i class="fas fa-database"></i> BD</a>
                </div>
            </div>
            
            <!-- Frase / Cita -->
            <div class="footer-quote">
                <div class="quote-card">
                    <i class="fas fa-quote-left quote-icon"></i>
                    <p class="quote-text">"La Salud es la Riqueza Real"</p>
                    <p class="quote-author">- MINSA Perú</p>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="footer-copyright">
            <p>
                <i class="fas fa-copyright"></i> {{ date('Y') }} DIEM · Todos los derechos reservados
            </p>
            <div class="footer-badges">
                <span class="badge-glass">Versión 2.0</span>
                <span class="badge-glass">Glassmorphism UI</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-glass {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(14, 124, 158, 0.15);
        padding: 24px 32px 20px;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.02);
    }
    
    .footer-section {
        padding: 0 6px;
    }
    
    .footer-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #1E3A5F;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.2px;
    }
    
    .footer-title i {
        color: #0E7C9E;
        font-size: 0.9rem;
    }
    
    .footer-contact-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .footer-contact-list p {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.75rem;
        color: #4A6A7A;
        margin: 0;
        transition: all 0.2s ease;
    }
    
    .footer-contact-list p i {
        width: 20px;
        color: #0E7C9E;
        font-size: 0.75rem;
    }
    
    .footer-contact-list p:hover {
        color: #0E7C9E;
        transform: translateX(3px);
    }
    
    .footer-links {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }
    
    .footer-links a {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.75rem;
        color: #4A6A7A;
        text-decoration: none;
        transition: all 0.2s ease;
        padding: 2px 0;
    }
    
    .footer-links a i {
        width: 20px;
        color: #0E7C9E;
        font-size: 0.75rem;
    }
    
    .footer-links a:hover {
        color: #0E7C9E;
        transform: translateX(3px);
    }
    
    .footer-quote {
        padding: 0 6px;
    }
    
    .quote-card {
        background: rgba(14, 124, 158, 0.04);
        backdrop-filter: blur(4px);
        border-radius: 16px;
        padding: 12px 16px;
        border: 1px solid rgba(14, 124, 158, 0.1);
        transition: all 0.3s ease;
    }
    
    .quote-card:hover {
        background: rgba(14, 124, 158, 0.08);
        transform: translateY(-1px);
        border-color: rgba(14, 124, 158, 0.25);
    }
    
    .quote-icon {
        color: rgba(14, 124, 158, 0.3);
        font-size: 1rem;
        margin-bottom: 5px;
    }
    
    .quote-text {
        font-size: 0.8rem;
        font-style: italic;
        color: #1E3A5F;
        margin: 0 0 5px 0;
        line-height: 1.35;
    }
    
    .quote-author {
        font-size: 0.65rem;
        color: #7A9AAA;
        margin: 0;
    }
    
    .footer-copyright {
        border-top: 1px solid rgba(14, 124, 158, 0.1);
        padding-top: 16px;
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .footer-copyright p {
        font-size: 0.65rem;
        color: #7A9AAA;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .footer-badges {
        display: flex;
        gap: 8px;
    }
    
    .badge-glass {
        font-size: 0.6rem;
        padding: 3px 10px;
        background: rgba(14, 124, 158, 0.1);
        border-radius: 30px;
        color: #0E7C9E;
        font-weight: 500;
        letter-spacing: -0.2px;
        border: 1px solid rgba(14, 124, 158, 0.2);
    }
    
    @media (max-width: 768px) {
        .footer-glass {
            padding: 20px 16px 16px;
            margin-top: 30px;
        }
        .footer-copyright {
            flex-direction: column;
            text-align: center;
        }
        .quote-card {
            padding: 10px 14px;
        }
        .grid {
            gap: 20px;
        }
    }
</style>