SET @codigo_buscado = '00003253';

SELECT  
    e.codigo AS codigo_ipress, 
    i.nombre AS institucion, 
    e.nombre_eess, 
    r.nombre AS region, 
    p.nombre AS provincia, 
    d.nombre AS distrito, 
    e.nombre_red AS red, 
    e.nombre_microred AS microred, 
    e.nivel_atencion, 
    cat.nombre AS categoria_actual, 
    e.resolucion_categoria, 
    e.clasificacion, 
    e.tipo, 
    e.codigo_ue, 
    e.unidad_ejecutora, 
    e.director_medico, 
    e.horario, 
    e.telefono, 
    e.inicio_funcionamiento, 
    e.fecha_registro, 
    e.ultima_recategorizacion, 
    e.antiguedad_anios, 
    e.categoria_inicial, 
    e.quintil, 
    e.pcm_zona, 
    e.frontera, 
    e.numero_camas, 
    e.autoridad_sanitaria, 
    e.propietario_ruc, 
    e.propietario_razon_social, 
    e.situacion_estado, 
    e.situacion_condicion, 
    e.direccion, 
    e.referencia, 
    e.coordenada_utm_norte, 
    e.coordenada_utm_este, 
    
    -- DATOS DE FORMAT (registrador)
    f.seguridad_hospitalaria, 
    f.seguridad_resultado, 
    f.seguridad_fecha, 
    f.patrimonio_cultural, 
    f.fecha_emision, 
    f.numero_documento, 
    f.tipo_documento_registrador, 
    f.doc_entidad_registrador, 
    f.nombre_registrador, 
    pr.nombre AS nombre_profesion,
    f.cargo_registrador,
    cp.nombre AS condicion_profesional,
    rl.nombre AS regimen_laboral,
    f.regimen_laboral_otro,
    f.email_registrador,
    f.movil_registrador,
    
    -- =============================================
    -- TABLA FORMAT_II (SERVICIOS BÁSICOS)
    -- =============================================
    
    -- AGUA
    fii.se_agua AS sb_agua,
    fii.se_agua_operativo AS sb_agua_operativo,
    fii.se_agua_estado AS sb_agua_estado,
    fii.se_agua_option AS sb_agua_opcion,
    fii.se_agua_fuente AS sb_agua_fuente,
    fii.se_agua_proveedor_ruc AS sb_agua_proveedor_ruc,
    fii.se_agua_proveedor AS sb_agua_proveedor,
    fii.se_servicio_agua AS sb_tiene_servicio_agua,
    fii.se_empresa_agua AS sb_empresa_agua,
    fii.se_horas_dia AS sb_horas_agua_por_dia,
    fii.se_horas_semana AS sb_horas_agua_por_semana,
    fii.se_sevicio_semana AS sb_servicio_continuo_semana,
    
    -- DESAGÜE / ALCANTARILLADO
    fii.se_desague AS sb_desague,
    fii.se_desague_operativo AS sb_desague_operativo,
    fii.se_desague_estado AS sb_desague_estado,
    fii.se_desague_option AS sb_desague_opcion,
    fii.se_desague_fuente AS sb_desague_fuente,
    fii.se_desague_proveedor_ruc AS sb_desague_proveedor_ruc,
    fii.se_desague_proveedor AS sb_desague_proveedor,
    fii.se_desague_otro AS sb_desague_otro,
    
    -- ELECTRICIDAD
    fii.se_electricidad AS sb_electricidad,
    fii.se_electricidad_operativo AS sb_electricidad_operativo,
    fii.se_electricidad_estado AS sb_electricidad_estado,
    fii.se_electricidad_option AS sb_electricidad_opcion,
    fii.se_electricidad_fuente AS sb_electricidad_fuente,
    fii.se_electricidad_proveedor_ruc AS sb_electricidad_proveedor_ruc,
    fii.se_electricidad_proveedor AS sb_electricidad_proveedor,
    
    -- TELEFONÍA FIJA
    fii.se_telefonia AS sb_telefonia,
    fii.se_telefonia_operativo AS sb_telefonia_operativo,
    fii.se_telefonia_estado AS sb_telefonia_estado,
    fii.se_telefonia_option AS sb_telefonia_opcion,
    fii.se_telefonia_fuente AS sb_telefonia_fuente,
    fii.se_telefonia_proveedor_ruc AS sb_telefonia_proveedor_ruc,
    fii.se_telefonia_proveedor AS sb_telefonia_proveedor,
    
    -- INTERNET
    fii.se_internet AS sb_internet,
    fii.se_internet_operativo AS sb_internet_operativo,
    fii.se_internet_estado AS sb_internet_estado,
    fii.se_internet_option AS sb_internet_opcion,
    fii.se_internet_fuente AS sb_internet_fuente,
    fii.se_internet_proveedor_ruc AS sb_internet_proveedor_ruc,
    fii.se_internet_proveedor AS sb_internet_proveedor,
    fii.internet AS sb_internet_tiene,
    fii.internet_operador AS sb_internet_operador,
    fii.internet_option1 AS sb_internet_tipo_conexion,
    fii.internet_red AS sb_internet_red,
    fii.internet_porcentaje AS sb_internet_porcentaje_cobertura,
    fii.internet_transmision AS sb_internet_transmision_datos,
    fii.internet_option2 AS sb_internet_servicio_adicional,
    fii.internet_servicio AS sb_internet_servicio_nombre,
    
    -- RED (INTRANET / LAN)
    fii.se_red AS sb_red_lan,
    fii.se_red_operativo AS sb_red_lan_operativo,
    fii.se_red_estado AS sb_red_lan_estado,
    fii.se_red_option AS sb_red_lan_opcion,
    fii.se_red_fuente AS sb_red_lan_fuente,
    fii.se_red_proveedor_ruc AS sb_red_lan_proveedor_ruc,
    fii.se_red_proveedor AS sb_red_lan_proveedor,
    
    -- GAS
    fii.se_gas AS sb_gas,
    fii.se_gas_operativo AS sb_gas_operativo,
    fii.se_gas_estado AS sb_gas_estado,
    fii.se_gas_option AS sb_gas_opcion,
    fii.se_gas_fuente AS sb_gas_fuente,
    fii.se_gas_proveedor_ruc AS sb_gas_proveedor_ruc,
    fii.se_gas_proveedor AS sb_gas_proveedor,
    
    -- RESIDUOS SÓLIDOS (MUNICIPALES)
    fii.se_residuos AS sb_residuos_solidos,
    fii.se_residuos_operativo AS sb_residuos_solidos_operativo,
    fii.se_residuos_estado AS sb_residuos_solidos_estado,
    fii.se_residuos_option AS sb_residuos_solidos_opcion,
    fii.se_residuos_fuente AS sb_residuos_solidos_fuente,
    fii.se_residuos_proveedor_ruc AS sb_residuos_solidos_proveedor_ruc,
    fii.se_residuos_proveedor AS sb_residuos_solidos_proveedor,
    
    -- RESIDUOS HOSPITALARIOS (PELIGROSOS/BIOCONTAMINADOS)
    fii.se_residuos_h AS sb_residuos_hospitalarios,
    fii.se_residuos_h_operativo AS sb_residuos_hospitalarios_operativo,
    fii.se_residuos_h_estado AS sb_residuos_hospitalarios_estado,
    fii.se_residuos_h_option AS sb_residuos_hospitalarios_opcion,
    fii.se_residuos_h_fuente AS sb_residuos_hospitalarios_fuente,
    fii.se_residuos_h_proveedor_ruc AS sb_residuos_hospitalarios_proveedor_ruc,
    fii.se_residuos_h_proveedor AS sb_residuos_hospitalarios_proveedor,
    
    -- SERVICIO DE LIMPIEZA
    fii.sc_servicio AS sb_servicio_limpieza,
    fii.sc_servicio_operativo AS sb_servicio_limpieza_operativo,
    fii.sc_servicio_estado AS sb_servicio_limpieza_estado,
    fii.sc_servicio_option AS sb_servicio_limpieza_opcion,
    fii.sc_servicio_fuente AS sb_servicio_limpieza_fuente,
    fii.sc_servicio_proveedor_ruc AS sb_servicio_limpieza_proveedor_ruc,
    fii.sc_servicio_proveedor AS sb_servicio_limpieza_proveedor,
    
    -- SERVICIOS HIGIÉNICOS (SSHH)
    fii.sc_sshh AS sb_servicios_higienicos,
    fii.sc_sshh_operativo AS sb_servicios_higienicos_operativo,
    fii.sc_sshh_estado AS sb_servicios_higienicos_estado,
    fii.sc_sshh_option AS sb_servicios_higienicos_opcion,
    fii.sc_sshh_fuente AS sb_servicios_higienicos_fuente,
    fii.sc_sshh_proveedor_ruc AS sb_servicios_higienicos_proveedor_ruc,
    fii.sc_sshh_proveedor AS sb_servicios_higienicos_proveedor,
    
    -- PERSONAL DE LIMPIEZA
    fii.sc_personal AS sb_personal_limpieza,
    fii.sc_personal_operativo AS sb_personal_limpieza_operativo,
    fii.sc_personal_estado AS sb_personal_limpieza_estado,
    fii.sc_personal_option AS sb_personal_limpieza_opcion,
    fii.sc_personal_fuente AS sb_personal_limpieza_fuente,
    fii.sc_personal_proveedor_ruc AS sb_personal_limpieza_proveedor_ruc,
    fii.sc_personal_proveedor AS sb_personal_limpieza_proveedor,
    
    -- VESTIDORES
    fii.sc_vestidores AS sb_vestidores,
    fii.sc_vestidores_estado AS sb_vestidores_estado,
    fii.sc_vestidores_option AS sb_vestidores_opcion,
    fii.sc_vestidores_fuente AS sb_vestidores_fuente,
    fii.sc_vestidores_proveedor_ruc AS sb_vestidores_proveedor_ruc,
    fii.sc_vestidores_proveedor AS sb_vestidores_proveedor,
    
    -- TELEVISIÓN
    fii.televicion AS sb_television,
    fii.televicion_operador AS sb_television_operador,
    fii.televicion_option1 AS sb_television_tipo,
    fii.televicion_espera AS sb_television_tiempo_espera,
    fii.televicion_porcentaje AS sb_television_porcentaje_cobertura,
    fii.televicion_antena AS sb_television_antena,
    fii.televicion_equipo AS sb_television_equipo_propio,
    
    -- =============================================
    -- CONTINÚA CON EL RESTO DE TU QUERY ORIGINAL
    -- (FORMAT_I, FORMAT_I_ONE, FORMAT_I_TWO, ETC.)
    -- =============================================
    
    -- DATOS DE TERRENO (format_i)
    fi.t_estado_saneado,
    fi.t_condicion_saneamiento,
    fi.t_nro_contrato,
    fi.t_titulo_a_favor,
    fi.t_observacion,
    fi.t_area_terreno,
    fi.t_area_construida,
    fi.t_area_estac,
    fi.t_area_libre,
    fi.t_estacionamiento,
    fi.t_inspeccion,
    fi.t_inspeccion_estado,
    
    -- PLANOS TECNICOS (format_i)
    fi.pf_ubicacion,
    fi.pf_estructuras,
    fi.pf_ins_mecanicas,
    fi.pf_perimetro,
    fi.pf_ins_sanitarias,
    fi.pf_ins_comunic,
    fi.pf_arquitectura,
    fi.pf_ins_electricas,
    fi.pf_distribuicion,
    fi.pd_ubicacion,
    fi.pd_perimetro,
    fi.pd_arquitectura,
    fi.pd_estructuras,
    fi.pd_ins_sanitarias,
    fi.pd_ins_electricas,
    fi.pd_ins_mecanicas,
    fi.pd_ins_comunic,
    fi.pd_distribuicion,
    
    -- ACABADOS EXTERIORES (format_i)
    fi.ae_pavimentos,
    fi.ae_pavimentos_nombre,
    fi.ae_pav_estado,
    fi.ae_veredas,
    fi.ae_veredas_nombre,
    fi.ae_ver_estado,
    fi.ae_zocalos,
    fi.ae_zocalos_nombre,
    fi.ae_zoc_estado,
    fi.ae_muros,
    fi.ae_muros_nombre,
    fi.ae_mur_estado,
    fi.ae_techo,
    fi.ae_techo_nombre,
    fi.ae_tec_estado,
    
    -- DATOS DE EDIFICACION (format_i_one)
    fio.id AS edificacion_id,
    fio.bloque,
    fio.pabellon,
    fio.servicio,
    fio.nropisos AS edificacion_nropisos,
    fio.antiguedad AS edificacion_antiguedad,
    fio.ultima_intervencion,
    fio.tipo_intervencion,
    fio.observacion AS edificacion_observacion,
    
    -- DATOS DE ACABADOS INTERIORES (format_i_two)
    fit.id AS acabado_id,
    fit.pisos,
    fit.pisos_nombre,
    fit.pisos_estado,
    fit.veredas,
    fit.veredas_nombre,
    fit.veredas_estado,
    fit.zocalos,
    fit.zocalos_nombre,
    fit.zocalos_estado,
    fit.muros,
    fit.muros_nombre,
    fit.muros_estado,
    fit.techo,
    fit.techo_nombre,
    fit.techo_estado,
    
    -- DATOS DEL EDIFICIO (format_i) 3.1.3.1
    fi.sonatos,
    fi.pisos AS num_pisos_superiores,
    fi.area AS area_aproximada,
    fi.ubicacion AS ubicacion_ee_ss,
    fi.material AS tipo_material,
    fi.material_nombre,
    
    -- EVALUACIÓN DEL ESTADO DE LA INFRAESTRUCTURA (format_i) 3.1.3.2
    fi.infraestructura_option_a,
    fi.infraestructura_valor_a,
    fi.infraestructura_descripcion_1,
    fi.infraestructura_option_b,
    fi.infraestructura_valor_b,
    fi.infraestructura_descripcion_2,
    fi.infraestructura_option_c,
    fi.infraestructura_valor_c,
    fi.infraestructura_descripcion_3,
    fi.infraestructura_option_d,
    fi.infraestructura_valor_d,
    fi.infraestructura_option_e,
    fi.infraestructura_valor_e,
    fi.infraestructura_option_f,
    fi.infraestructura_valor_f,
    fi.infraestructura_option_g,
    fi.infraestructura_valor_g,
    fi.infraestructura_option_h,
    fi.infraestructura_valor_h,
    fi.infraestructura_option_i,
    fi.infraestructura_valor_i,
    fi.infraestructura_option_j,
    fi.infraestructura_valor_j,
    fi.infraestructura_option_k,
    fi.infraestructura_valor_k,
    fi.infraestructura_option_l,
    fi.infraestructura_valor_l,
    fi.infraestructura_option_m,
    fi.infraestructura_valor_m,
    fi.infraestructura_option_n,
    fi.infraestructura_valor_n,
    fi.infraestructura_descripcion_a,
    fi.infraestructura_descripcion_b,
    fi.infraestructura_descripcion_c,
    fi.infraestructura_descripcion_d,
    fi.infraestructura_descripcion_e,
    fi.infraestructura_descripcion_f,
    fi.infraestructura_descripcion_g,
    fi.infraestructura_descripcion_h,
    fi.infraestructura_descripcion_i,
    fi.infraestructura_descripcion_j,
    fi.infraestructura_descripcion_k,
    fi.infraestructura_descripcion_l,
    fi.infraestructura_descripcion_m,
    fi.infraestructura_descripcion_n,
    
    -- ESTADO DEL ENTORNO / CERRAMIENTO PERIMETRAL
    fi.estado_contencion,
    fi.estado_taludes,
    fi.cp_erco_perim,
    fi.cp_material,
    fi.cp_material_nombre,
    fi.cp_estado,
    
    -- OBSERVACIONES DEL EVALUADOR
    fi.observacion,
    fi.fecha_evaluacion,
    fi.hora_inicio,
    fi.hora_final,
    fi.comentarios,
    
    -- FOTOS / ARCHIVOS
    fif.id AS foto_id,
    fif.nombre AS foto_nombre,
    fif.url AS foto_url,
    fif.size AS foto_size,
    fif.created_at AS foto_created_at,
    
    -- ACCESIBILIDAD
    fi.ac_option_1,
    fi.ac_option_2,
    fi.ac_option_3,
    fi.ac_option_4,
    
    -- UBICACIÓN
    fi.ub_option_1,
    fi.ub_option_2,
    fi.ub_option_3,
    fi.ub_option_4,
    fi.ub_option_5,
    fi.ub_option_6,
    fi.ub_option_7,
    fi.ub_option_8,
    fi.ub_option_9,
    fi.ub_option_10,
    fi.ub_option_11,
    fi.ub_option_12,
    fi.ub_option_13,
    
    -- HORIZONTAL
    fi.ch_option_1,
    fi.ch_option_2,
    fi.ch_option_3,
    fi.ch_option_4,
    fi.ch_ancho,
    fi.ch_option_5,
    fi.ch_option_6,
    fi.ch_option_7,
    fi.ch_option_8,
    fi.ch_option_9,
    
    -- VERTICAL
    fi.cv_option_1,
    fi.cv_option_2,
    fi.cv_option_3,
    fi.cv_option_4,
    fi.cv_option_5,
    fi.cv_option_6,
    fi.cv_option_7,
    fi.cv_option_8,
    fi.cv_option_9,
    fi.cv_option_10

FROM establishment e 
LEFT JOIN institucion i ON e.id_institucion = i.id 
LEFT JOIN regions r ON e.idregion = r.id 
LEFT JOIN provinces p ON e.idprovincia = p.id 
LEFT JOIN districts d ON e.iddistrito = d.id 
LEFT JOIN niveles cat ON e.id_categoria = cat.id 
LEFT JOIN format f ON e.id = f.id_establecimiento 
LEFT JOIN format_i fi ON e.id = fi.id_establecimiento  
LEFT JOIN format_i_one fio ON fi.id = fio.id_format_i
LEFT JOIN format_i_two fit ON fio.id = fit.id_format_i_one
LEFT JOIN format_i_files fif ON fi.id = fif.id_format_i AND fif.tipo = 1
LEFT JOIN profesion pr ON f.id_profesion_registrador = pr.id 
LEFT JOIN condicion_profesional cp ON f.id_condicion_profesional = cp.id
LEFT JOIN regimen_laboral rl ON f.id_regimen_laboral = rl.id
LEFT JOIN format_ii fii ON e.id = fii.id_establecimiento   -- ← CORREGIDO: format_ii (con dos i)

WHERE LPAD(e.codigo, 8, '0') COLLATE utf8mb4_unicode_ci = LPAD(@codigo_buscado, 8, '0') COLLATE utf8mb4_unicode_ci
LIMIT 0, 1000;