use db_oniees_main;
describe establishment;
describe format;
describe format_i;
describe profesion;
describe condicion_profesional;
describe regimen_laboral;
describe format_i_one;
describe format_i_two;
DESCRIBE format_i_files;
describe format_ii;


SELECT * FROM db_oniees_main.establishment ;
SELECT * FROM db_oniees_main.format where codigo_ipre = 1013;
SELECT * FROM db_oniees_main.establishment where codigo = 3253;
SELECT * FROM db_oniees_main.format;
SELECT * FROM db_oniees_main.format_i_files;

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
    
	-- evaluación del estado de la infraestructura (format_i) 3.1.3.2
	  -- EVALUACIÓN DEL ESTADO DE LA INFRAESTRUCTURA (format_i) 3.1.3.2
    -- Opciones (SI/NO)
    -- Par A
	fi.infraestructura_option_a,
	fi.infraestructura_valor_a,
	fi.infraestructura_descripcion_1,
	-- Par B
	fi.infraestructura_option_b,
	fi.infraestructura_valor_b,
	fi.infraestructura_descripcion_2,
	-- Par C
	fi.infraestructura_option_c,
	fi.infraestructura_valor_c,
	fi.infraestructura_descripcion_3,
	-- Par D
	fi.infraestructura_option_d,
	fi.infraestructura_valor_d,
	-- Par E
	fi.infraestructura_option_e,
	fi.infraestructura_valor_e,
	-- Par F
	fi.infraestructura_option_f,
	fi.infraestructura_valor_f,
	-- Par G
	fi.infraestructura_option_g,
	fi.infraestructura_valor_g,
	-- Par H
	fi.infraestructura_option_h,
	fi.infraestructura_valor_h,
	-- Par I
	fi.infraestructura_option_i,
	fi.infraestructura_valor_i,
	-- Par J
	fi.infraestructura_option_j,
	fi.infraestructura_valor_j,
	-- Par K
	fi.infraestructura_option_k,
	fi.infraestructura_valor_k,
	-- Par L
	fi.infraestructura_option_l,
	fi.infraestructura_valor_l,
	-- Par M
	fi.infraestructura_option_m,
	fi.infraestructura_valor_m,
	-- Par N
	fi.infraestructura_option_n,
	fi.infraestructura_valor_n,
    -- Descripciones

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
    
    -- 3.1.3.4 OBSERVACIONES, COMENTARIOS Y/O APRECIACIONES DEL EVALUADOR
    fi.observacion,
    
     -- 3.1.3.5 IDENTIFICACION PREMILINAR DE TIPO DE INTERVENCION 
	fi.fecha_evaluacion,
    fi.hora_inicio,
    fi.hora_final,
   
     -- 3.1.3.6 DETERMINACION DE LA OPERATIVIDAD DE LA INFRAESTRCTURA DEL ESTABLECIMIENTO DE SALUD
     fi.comentarios,
   
    -- FOTOS / ARCHIVOS / PLANOS (format_i_files)
	fif.id AS foto_id,
	fif.nombre AS foto_nombre,
	fif.url AS foto_url,
	fif.size AS foto_size,
	fif.created_at AS foto_created_at,
	
    -- Accesibilidad
	fi.ac_option_1,
	fi.ac_option_2,
	fi.ac_option_3,
	fi.ac_option_4,

	-- Ubicación
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

	-- Horizontal
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

	-- Vertical
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

    -- SERVICIOS BASICOS

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
LEFT JOIN format_i_files fif ON fi.id = fif.id_format_i AND fif.tipo = 1  -- ← FOTOS
LEFT JOIN profesion pr ON f.id_profesion_registrador = pr.id 
LEFT JOIN condicion_profesional cp ON f.id_condicion_profesional = cp.id
LEFT JOIN regimen_laboral rl ON f.id_regimen_laboral = rl.id

WHERE LPAD(e.codigo, 8, '0') COLLATE utf8mb4_unicode_ci = LPAD(@codigo_buscado, 8, '0') COLLATE utf8mb4_unicode_ci
LIMIT 0, 1000;