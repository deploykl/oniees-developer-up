<style>
    /* Variables de diseño */
    :root {
        --primary: #0E7C9E;
        --primary-light: #e6f4f7;
        --primary-dark: #0a5c77;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --radius-lg: 1rem;
        --radius-md: 0.75rem;
        --radius-sm: 0.5rem;
    }

    .form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .form-section {
        background: white;
        border-radius: var(--radius-lg);
        margin-bottom: 1rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .form-section:hover {
        box-shadow: var(--shadow-md);
    }

    .section-header {
        padding: 1rem 1.5rem;
        background: linear-gradient(to right, var(--gray-50), white);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .section-header:hover {
        background: linear-gradient(to right, #f1f5f9, #f8fafc);
    }

    .section-header-left {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .section-title .accordion-icon {
        transition: transform 0.2s ease;
        font-size: 0.8rem;
        color: var(--gray-500);
    }

    .section-subtitle {
        font-size: 0.7rem;
        color: var(--gray-600);
        margin-left: 1.9rem;
    }

    .section-badge {
        background: var(--primary-light);
        color: var(--primary);
        font-size: 0.6rem;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-weight: 500;
    }

    .section-content {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .section-content.hidden {
        display: none;
    }

    .progress-counter {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .counter-number {
        font-family: monospace;
        font-size: 1rem;
        font-weight: 700;
    }

    .counter-number .completed { color: #10b981; }
    .counter-number .total { color: var(--gray-600); }

    .counter-bar {
        width: 80px;
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        overflow: hidden;
    }

    .counter-bar-fill {
        height: 100%;
        border-radius: 2px;
        transition: width 0.3s ease;
    }

    .counter-bar-fill.complete { background: linear-gradient(90deg, #10b981, #34d399); }
    .counter-bar-fill.incomplete { background: linear-gradient(90deg, #ef4444, #f87171); }
    .counter-bar-fill.partial { background: linear-gradient(90deg, var(--primary), #38bdf8); }

    .counter-percent {
        font-size: 0.7rem;
        font-weight: 600;
        min-width: 45px;
        text-align: right;
    }

    .counter-percent.complete { color: #10b981; }
    .counter-percent.incomplete { color: #ef4444; }
    .counter-percent.partial { color: var(--primary); }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
        padding: 1.5rem;
    }

    .form-field {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        font-size: 0.7rem;
        color: var(--primary);
    }

    .form-label .required { color: #ef4444; }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        transition: all 0.2s ease;
        background: white;
        color: var(--gray-800);
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(14, 124, 158, 0.1);
    }

    .form-input-readonly {
        background: var(--gray-50);
        border-color: var(--gray-200);
        color: var(--gray-600);
        cursor: default;
    }

    .field-with-icon { position: relative; }
    .field-with-icon .form-input { padding-right: 2.5rem; }
    .field-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-size: 0.75rem;
    }

    .radio-group {
        display: flex;
        gap: 1.5rem;
        align-items: center;
        padding: 0.5rem 0;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .radio-option input[type="radio"] {
        width: 1rem;
        height: 1rem;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .radio-option span {
        font-size: 0.85rem;
        color: var(--gray-700);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1rem 1.5rem 1.5rem;
        background: var(--gray-50);
        border-top: 1px solid var(--gray-200);
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background: white;
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
        padding: 0.7rem 1.5rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        color: var(--gray-800);
    }

    @media (min-width: 1024px) { .form-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) {
        .form-container { padding: 1rem; }
        .form-grid { grid-template-columns: 1fr; gap: 1rem; }
        .section-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<script>
    function sectionCounter(sectionId, total) {
        return {
            sectionId: sectionId,
            total: total,
            filled: 0,
            percent: 0,
            open: localStorage.getItem('accordion_' + sectionId) !== 'false',

            toggle() {
                this.open = !this.open;
                localStorage.setItem('accordion_' + this.sectionId, this.open);
                setTimeout(() => this.update(), 50);
            },

            init() {
                setTimeout(() => this.update(), 100);
                const section = document.getElementById(this.sectionId);
                if (section) {
                    const inputs = section.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('change', () => this.update());
                        input.addEventListener('input', () => this.update());
                    });
                }
            },

            update() {
                const section = document.getElementById(this.sectionId);
                if (!section) return;

                const inputs = section.querySelectorAll('input, select, textarea');
                let count = 0;
                inputs.forEach(input => {
                    if (input.value && input.value.trim() !== '' && input.value !== 'null') {
                        count++;
                    }
                });

                this.filled = count;
                this.percent = Math.min(Math.round((count / this.total) * 100), 100);

                window.dispatchEvent(new CustomEvent('sectionProgress', {
                    detail: { section: this.sectionId, filled: count, total: this.total, percent: this.percent }
                }));
            }
        };
    }
</script>

<div class="form-container">

    <!-- ============================================ -->
    <!-- SECCIÓN 1: DATOS GENERALES -->
    <!-- ============================================ -->
    <div id="sec-datos-generales" class="form-section" x-data="sectionCounter('sec-datos-generales', 18)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title">
                    <i class="fas fa-hospital"></i> Datos Generales
                    <span class="section-badge">Información básica</span>
                    <i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </h2>
                <p class="section-subtitle">Datos principales del establecimiento de salud</p>
            </div>
            <div class="progress-counter" @click.stop>
                <div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div>
                <div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div>
                <div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div>
            </div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <div class="form-field"><label class="form-label"><i class="fas fa-qrcode"></i> CÓDIGO IPRESS <span class="required">*</span></label>
                    <div class="field-with-icon"><input type="text" name="codigo_ipress" class="form-input form-input-readonly" value="{{ $establecimiento->codigo ?? '' }}" readonly><i class="fas fa-lock field-icon"></i></div>
                </div>
                <div class="form-field"><label class="form-label"><i class="fas fa-building"></i> NOMBRE DEL EESS <span class="required">*</span></label><input type="text" name="nombre_eess" class="form-input form-input-readonly" value="{{ $establecimiento->nombre_eess ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-landmark"></i> INSTITUCIÓN</label><input type="text" name="institucion" class="form-input form-input-readonly" value="{{ $establecimiento->institucion ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-map-marker-alt"></i> REGIÓN</label><input type="text" name="region" class="form-input form-input-readonly" value="{{ $establecimiento->region ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-map-pin"></i> PROVINCIA</label><input type="text" name="provincia" class="form-input form-input-readonly" value="{{ $establecimiento->provincia ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-location-dot"></i> DISTRITO</label><input type="text" name="distrito" class="form-input form-input-readonly" value="{{ $establecimiento->distrito ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-network-wired"></i> RED</label><input type="text" name="red" class="form-input form-input-readonly" value="{{ $establecimiento->nombre_red ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-code-branch"></i> MICRORED</label><input type="text" name="microred" class="form-input form-input-readonly" value="{{ $establecimiento->nombre_microred ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-chart-line"></i> NIVEL DE ATENCIÓN</label><select name="nivel_atencion" class="form-select"><option value="">Seleccione</option><option value="I" {{ ($establecimiento->nivel_atencion ?? '') == 'I' ? 'selected' : '' }}>I Nivel</option><option value="II" {{ ($establecimiento->nivel_atencion ?? '') == 'II' ? 'selected' : '' }}>II Nivel</option><option value="III" {{ ($establecimiento->nivel_atencion ?? '') == 'III' ? 'selected' : '' }}>III Nivel</option></select></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-tag"></i> CATEGORÍA</label><input type="text" name="categoria" class="form-input form-input-readonly" value="{{ $establecimiento->categoria ?? '' }}" readonly></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-file-alt"></i> RESOLUCIÓN DE CATEGORÍA</label><input type="text" name="resolucion_categoria" class="form-input" value="{{ $establecimiento->resolucion_categoria ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-layer-group"></i> CLASIFICACIÓN</label><input type="text" name="clasificacion" class="form-input" value="{{ $establecimiento->clasificacion ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-cubes"></i> TIPO</label><input type="text" name="tipo" class="form-input" value="{{ $establecimiento->tipo ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-barcode"></i> COD UE</label><input type="text" name="codigo_ue" class="form-input" value="{{ $establecimiento->codigo_ue ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-building"></i> UNIDAD EJECUTORA</label><input type="text" name="unidad_ejecutora" class="form-input" value="{{ $establecimiento->unidad_ejecutora ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-phone"></i> TELÉFONO</label><input type="text" name="telefono" class="form-input" value="{{ $establecimiento->telefono ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-user-md"></i> DIRECTOR MÉDICO</label><input type="text" name="director_medico" class="form-input" value="{{ $establecimiento->director_medico ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-clock"></i> HORARIO</label><input type="text" name="horario" class="form-input" value="{{ $establecimiento->horario ?? '' }}"></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 2: INFORMACIÓN RED/DIRESA -->
    <!-- ============================================ -->
    <div id="sec-red-diresa" class="form-section" x-data="sectionCounter('sec-red-diresa', 8)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left">
                <h2 class="section-title"><i class="fas fa-shield-alt"></i> Información de RED/DIRESA <span class="section-badge">Fuente oficial</span><i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i></h2>
                <p class="section-subtitle">Información proporcionada por los Servicios de Salud de la RED o DIRESA</p>
            </div>
            <div class="progress-counter" @click.stop><div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div><div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div><div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div></div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <div class="form-field"><label class="form-label"><i class="fas fa-calendar-alt"></i> INICIO DE FUNCIONAMIENTO</label><input type="date" name="inicio_funcionamiento" class="form-input" value="{{ $establecimiento->inicio_funcionamiento ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-calendar-check"></i> FECHA REGISTRO</label><input type="date" name="fecha_registro" class="form-input" value="{{ $establecimiento->fecha_registro ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-calendar-week"></i> ÚLTIMA RECATEGORIZACIÓN</label><input type="date" name="ultima_recategorizacion" class="form-input" value="{{ $establecimiento->ultima_recategorizacion ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-hourglass-half"></i> ANTIGÜEDAD (años)</label><input type="number" name="antiguedad" class="form-input" value="{{ $establecimiento->antiguedad_anios ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-flag-checkered"></i> CATEGORÍA INICIAL</label><input type="text" name="categoria_inicial" class="form-input" value="{{ $establecimiento->categoria_inicial ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-chart-simple"></i> QUINTIL</label><input type="number" name="quintil" class="form-input" value="{{ $establecimiento->quintil ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-city"></i> PCM/ZONA</label><select name="pcm_zona" class="form-select"><option value="">Seleccione</option><option value="URBANO" {{ ($establecimiento->pcm_zona ?? '') == 'URBANO' ? 'selected' : '' }}>URBANO</option><option value="RURAL" {{ ($establecimiento->pcm_zona ?? '') == 'RURAL' ? 'selected' : '' }}>RURAL</option><option value="URBANO MARGINAL" {{ ($establecimiento->pcm_zona ?? '') == 'URBANO MARGINAL' ? 'selected' : '' }}>URBANO MARGINAL</option></select></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-globe"></i> FRONTERA</label><select name="frontera" class="form-select"><option value="">Seleccione</option><option value="1" {{ ($establecimiento->frontera ?? '') == '1' ? 'selected' : '' }}>Sí</option><option value="0" {{ ($establecimiento->frontera ?? '') == '0' ? 'selected' : '' }}>No</option></select></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 3: DATOS ADICIONALES -->
    <!-- ============================================ -->
    <div id="sec-datos-adicionales" class="form-section" x-data="sectionCounter('sec-datos-adicionales', 6)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left"><h2 class="section-title"><i class="fas fa-database"></i> Datos Adicionales <span class="section-badge">Complementarios</span><i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i></h2><p class="section-subtitle">Información complementaria del establecimiento</p></div>
            <div class="progress-counter" @click.stop><div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div><div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div><div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div></div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <div class="form-field"><label class="form-label"><i class="fas fa-bed"></i> NÚMERO DE CAMAS</label><input type="number" name="numero_camas" class="form-input" value="{{ $establecimiento->numero_camas ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-user-shield"></i> AUTORIDAD SANITARIA</label><input type="text" name="autoridad_sanitaria" class="form-input" value="{{ $establecimiento->autoridad_sanitaria ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-id-card"></i> PROPIETARIO RUC</label><input type="text" name="propietario_ruc" class="form-input" value="{{ $establecimiento->propietario_ruc ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-building"></i> PROPIETARIO RAZÓN SOCIAL</label><input type="text" name="propietario_razon_social" class="form-input" value="{{ $establecimiento->propietario_razon_social ?? '' }}"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-chart-line"></i> SITUACIÓN ESTADO</label><select name="situacion_estado" class="form-select"><option value="">Seleccione</option><option value="REGULAR" {{ ($establecimiento->situacion_estado ?? '') == 'REGULAR' ? 'selected' : '' }}>REGULAR</option><option value="BUENO" {{ ($establecimiento->situacion_estado ?? '') == 'BUENO' ? 'selected' : '' }}>BUENO</option><option value="MALO" {{ ($establecimiento->situacion_estado ?? '') == 'MALO' ? 'selected' : '' }}>MALO</option></select></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-clipboard-list"></i> SITUACIÓN CONDICIÓN</label><select name="situacion_condicion" class="form-select"><option value="">Seleccione</option><option value="MAL" {{ ($establecimiento->situacion_condicion ?? '') == 'MAL' ? 'selected' : '' }}>MAL</option><option value="REGULAR" {{ ($establecimiento->situacion_condicion ?? '') == 'REGULAR' ? 'selected' : '' }}>REGULAR</option><option value="BUENO" {{ ($establecimiento->situacion_condicion ?? '') == 'BUENO' ? 'selected' : '' }}>BUENO</option><option value="EXCELENTE" {{ ($establecimiento->situacion_condicion ?? '') == 'EXCELENTE' ? 'selected' : '' }}>EXCELENTE</option></select></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 4: LOCALIZACIÓN GEOGRÁFICA -->
    <!-- ============================================ -->
    <div id="sec-localizacion" class="form-section" x-data="sectionCounter('sec-localizacion', 5)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left"><h2 class="section-title"><i class="fas fa-map-marked-alt"></i> Localización Geográfica <span class="section-badge">Coordenadas</span><i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i></h2><p class="section-subtitle">Ubicación y coordenadas del establecimiento</p></div>
            <div class="progress-counter" @click.stop><div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div><div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div><div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div></div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <div class="form-field"><label class="form-label"><i class="fas fa-road"></i> DIRECCIÓN</label><input type="text" name="direccion" class="form-input" value="{{ $establecimiento->direccion ?? '' }}" placeholder="Ej: JR. SIDERAL S/N"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-location-dot"></i> REFERENCIA</label><input type="text" name="referencia" class="form-input" value="{{ $establecimiento->referencia ?? '' }}" placeholder="Ej: Cerca al mercado central"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-mountain"></i> ALTITUD (msnm)</label><input type="number" name="cota" class="form-input" value="{{ $establecimiento->cota ?? '' }}" placeholder="Ej: 3833"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-arrow-up"></i> UTM NORTE</label><input type="text" name="coord_utm_norte" class="form-input" value="{{ $establecimiento->coordenada_utm_norte ?? '' }}" placeholder="Ej: -15.863840"></div>
                <div class="form-field"><label class="form-label"><i class="fas fa-arrow-right"></i> UTM ESTE</label><input type="text" name="coord_utm_este" class="form-input" value="{{ $establecimiento->coordenada_utm_este ?? '' }}" placeholder="Ej: 1234567"></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 5: SEGURIDAD HOSPITALARIA -->
    <!-- ============================================ -->
    <div id="sec-seguridad" class="form-section" x-data="sectionCounter('sec-seguridad', 3)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left"><h2 class="section-title"><i class="fas fa-shield-virus"></i> Índice de Seguridad Hospitalaria <span class="section-badge">Evaluación</span><i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i></h2></div>
            <div class="progress-counter" @click.stop><div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div><div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div><div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div></div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <div class="form-field"><label class="form-label">¿CUENTA CON EL DOCUMENTO?</label><div class="radio-group"><label class="radio-option"><input type="radio" name="tiene_documento_seguridad" value="1" {{ ($format->seguridad_hospitalaria ?? '') == 'SI' ? 'checked' : '' }} onclick="$('#resultado_seguridad_div').slideDown(200)"><span>SÍ</span></label><label class="radio-option"><input type="radio" name="tiene_documento_seguridad" value="0" {{ ($format->seguridad_hospitalaria ?? '') == 'NO' ? 'checked' : '' }} onclick="$('#resultado_seguridad_div').slideUp(200)"><span>NO</span></label></div></div>
            </div>
            <div id="resultado_seguridad_div" style="display: {{ ($format->seguridad_hospitalaria ?? '') == 'SI' ? 'block' : 'none' }}; padding: 0 1.5rem 1.5rem;">
                <div class="form-grid"><div class="form-field"><label class="form-label">RESULTADO</label><select name="resultado_seguridad" class="form-select"><option value="">Seleccione</option><option value="CATEGORIA A" {{ ($format->seguridad_resultado ?? '') == 'CATEGORIA A' ? 'selected' : '' }}>CATEGORIA A</option><option value="CATEGORIA B" {{ ($format->seguridad_resultado ?? '') == 'CATEGORIA B' ? 'selected' : '' }}>CATEGORIA B</option><option value="CATEGORIA C" {{ ($format->seguridad_resultado ?? '') == 'CATEGORIA C' ? 'selected' : '' }}>CATEGORIA C</option></select></div><div class="form-field"><label class="form-label">FECHA DE EVALUACIÓN</label><input type="date" name="anio_seguridad" class="form-input" value="{{ $format->seguridad_fecha ?? '' }}"></div></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 6: PATRIMONIO CULTURAL -->
    <!-- ============================================ -->
    <div id="sec-patrimonio" class="form-section" x-data="sectionCounter('sec-patrimonio', 3)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left"><h2 class="section-title"><i class="fas fa-landmark"></i> Patrimonio Cultural <span class="section-badge">Declaratoria</span><i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i></h2></div>
            <div class="progress-counter" @click.stop><div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div><div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div><div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div></div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid"><div class="form-field"><label class="form-label">¿ES PATRIMONIO CULTURAL?</label><div class="radio-group"><label class="radio-option"><input type="radio" name="patrimonio_cultural" value="1" {{ ($format->patrimonio_cultural ?? '') == 'SI' ? 'checked' : '' }} onclick="$('#patrimonio_data').slideDown(200)"><span>SÍ</span></label><label class="radio-option"><input type="radio" name="patrimonio_cultural" value="0" {{ ($format->patrimonio_cultural ?? '') == 'NO' ? 'checked' : '' }} onclick="$('#patrimonio_data').slideUp(200)"><span>NO</span></label></div></div></div>
            <div id="patrimonio_data" style="display: {{ ($format->patrimonio_cultural ?? '') == 'SI' ? 'block' : 'none' }}; padding: 0 1.5rem 1.5rem;">
                <div class="form-grid"><div class="form-field"><label class="form-label">FECHA DE RECONOCIMIENTO</label><input type="date" name="fecha_patrimonio" class="form-input" value="{{ $format->fecha_emision ?? '' }}"></div><div class="form-field"><label class="form-label">NÚMERO DE RESOLUCIÓN</label><input type="text" name="num_resolucion_patrimonio" class="form-input" value="{{ $format->numero_documento ?? '' }}" placeholder="Ej: 045-2024"></div></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SECCIÓN 7: DIRECTOR / ADMINISTRADOR -->
    <!-- ============================================ -->
    <div id="sec-director" class="form-section" x-data="sectionCounter('sec-director', 9)" x-init="init()">
        <div class="section-header" @click="toggle()">
            <div class="section-header-left"><h2 class="section-title"><i class="fas fa-user-tie"></i> Director / Administrador <span class="section-badge">Responsable</span><i class="fas accordion-icon" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i></h2></div>
            <div class="progress-counter" @click.stop><div class="counter-number"><span class="completed" x-text="filled"></span><span class="total">/<span x-text="total"></span></span></div><div class="counter-bar"><div class="counter-bar-fill" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" :style="{ width: percent + '%' }"></div></div><div class="counter-percent" :class="percent === 100 ? 'complete' : (percent > 0 ? 'partial' : 'incomplete')" x-text="percent + '%'"></div></div>
        </div>
        <div class="section-content" :class="open ? '' : 'hidden'">
            <div class="form-grid">
                <div class="form-field"><label class="form-label">TIPO DE DOCUMENTO</label><select name="director_tipo_documento" class="form-select"><option value="">Seleccione</option>@foreach ($tiposDocumento as $tipo)<option value="{{ $tipo->id }}" {{ ($format->tipo_documento_registrador ?? '') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>@endforeach</select></div>
                <div class="form-field"><label class="form-label">DOCUMENTO DE IDENTIDAD</label><input type="text" name="director_dni" class="form-input" value="{{ $format->doc_entidad_registrador ?? '' }}" placeholder="02413179"></div>
                <div class="form-field"><label class="form-label">NOMBRES Y APELLIDOS</label><input type="text" name="director_nombres" class="form-input" value="{{ $format->nombre_registrador ?? '' }}" placeholder="ZORAIDA MATILDE PALZA VALDIVIA"></div>
                <div class="form-field"><label class="form-label">PROFESIÓN</label><select name="director_profesion" class="form-select"><option value="">Seleccione</option>@foreach ($profesiones as $prof)<option value="{{ $prof->id }}" {{ ($format->id_profesion_registrador ?? '') == $prof->id ? 'selected' : '' }}>{{ $prof->nombre }}</option>@endforeach</select></div>
                <div class="form-field"><label class="form-label">CARGO / FUNCIÓN</label><input type="text" name="director_cargo" class="form-input" value="{{ $format->cargo_registrador ?? '' }}" placeholder="JEFE DE ESTABLECIMIENTO"></div>
                <div class="form-field"><label class="form-label">CONDICIÓN LABORAL</label><select name="director_condicion_laboral" class="form-select"><option value="">Seleccione</option>@foreach ($condiciones as $cond)<option value="{{ $cond->id }}" {{ ($format->id_condicion_profesional ?? '') == $cond->id ? 'selected' : '' }}>{{ $cond->nombre }}</option>@endforeach</select></div>
                <div class="form-field"><label class="form-label">RÉGIMEN LABORAL</label><select name="director_regimen_laboral" class="form-select"><option value="">Seleccione</option>@foreach ($regimenes as $reg)<option value="{{ $reg->id }}" {{ ($format->id_regimen_laboral ?? '') == $reg->id ? 'selected' : '' }}>{{ $reg->nombre }}</option>@endforeach</select></div>
                <div class="form-field"><label class="form-label">CORREO ELECTRÓNICO</label><input type="email" name="director_email" class="form-input" value="{{ $format->email_registrador ?? '' }}" placeholder="correo@ejemplo.com"></div>
                <div class="form-field"><label class="form-label">TELÉFONO / CELULAR</label><input type="tel" name="director_celular" class="form-input" value="{{ $format->movil_registrador ?? '' }}" placeholder="999999999"></div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="form-actions">
        <button type="reset" class="btn-secondary"><i class="fas fa-eraser"></i> Limpiar</button>
        <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
    </div>
</div>