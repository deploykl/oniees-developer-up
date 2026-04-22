<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class EstadisticaController extends Controller
{
    public function index() {
        $response = [
            [
                "institucion" => "GOBIERNO REGIONAL",
                "actividad" => "DATOS GENERALES",
                "agrupacion" => "REGION",
                "total" => 4702
            ], 
            [
                "institucion" => "MINSA",
                "actividad" => "DATOS GENERALES",
                "agrupacion" => "REGION",
                "total" => 26
            ],
            [
                "institucion" => "MINSA",
                "actividad" => "DATOS GENERALES",
                "agrupacion" => "LIMA METROPOLITANA",
                "total" => 195
            ],
            [
                "institucion" => "GOBIERNO REGIONAL",
                "actividad" => "INFRAESTRUCTURA",
                "agrupacion" => "REGION",
                "total" => 3788
            ], 
            [
                "institucion" => "MINSA",
                "actividad" => "INFRAESTRUCTURA",
                "agrupacion" => "REGION",
                "total" => 103
            ],
            [
                "institucion" => "MINSA",
                "actividad" => "INFRAESTRUCTURA",
                "agrupacion" => "LIMA METROPOLITANA",
                "total" => 1
            ],
            [
                "institucion" => "GOBIERNO REGIONAL",
                "actividad" => "SERVICIOS BASICOS",
                "agrupacion" => "REGION",
                "total" => 3445
            ], 
            [
                "institucion" => "MINSA",
                "actividad" => "SERVICIOS BASICOS",
                "agrupacion" => "REGION",
                "total" => 15
            ],
            [
                "institucion" => "MINSA",
                "actividad" => "SERVICIOS BASICOS",
                "agrupacion" => "LIMA METROPOLITANA",
                "total" => 186
            ],
        ];
                
        return response()->json($response);
    }
    
    public function regiones() {
        $response = [
            "regiones" => [
                [
                    "nombre" => "LIMA NORTE",
                    "total" => 119,
                    "avance" => 3,
                    "pendiente" => 116,
                ],
                [
                    "nombre" => "LIMA CENTRO",
                    "total" => 103,
                    "avance" => 5,
                    "pendiente" => 98,
                ],
                [
                    "nombre" => "TACNA",
                    "total" => 84,
                    "avance" => 15,
                    "pendiente" => 69,
                ],
                [
                    "nombre" => "UCAYALI",
                    "total" => 231,
                    "avance" => 58,
                    "pendiente" => 173,
                ],
                [
                    "nombre" => "LORETO",
                    "total" => 492,
                    "avance" => 164,
                    "pendiente" => 328,
                ],
                [
                    "nombre" => "PUNO",
                    "total" => 490,
                    "avance" => 171,
                    "pendiente" => 319,
                ],
                [
                    "nombre" => "ICA",
                    "total" => 154,
                    "avance" => 57,
                    "pendiente" => 97,
                ],
                [
                    "nombre" => "LIMA ESTE",
                    "total" => 95,
                    "avance" => 46,
                    "pendiente" => 49,
                ],
                [
                    "nombre" => "CAJAMARCA",
                    "total" => 890,
                    "avance" => 434,
                    "pendiente" => 456,
                ],
                [
                    "nombre" => "AMAZONAS",
                    "total" => 493,
                    "avance" => 250,
                    "pendiente" => 243,
                ],
                [
                    "nombre" => "HUANCAVELICA",
                    "total" => 418,
                    "avance" => 216,
                    "pendiente" => 202,
                ],
                [
                    "nombre" => "SAN MARTIN",
                    "total" => 386,
                    "avance" => 204,
                    "pendiente" => 182,
                ],
                [
                    "nombre" => "CUSCO",
                    "total" => 365,
                    "avance" => 198,
                    "pendiente" => 167,
                ],
                [
                    "nombre" => "ANCASH",
                    "total" => 437,
                    "avance" => 245,
                    "pendiente" => 192,
                ],
                [
                    "nombre" => "MOQUEGUA",
                    "total" => 73,
                    "avance" => 41,
                    "pendiente" => 32,
                ],
                [
                    "nombre" => "AYACUCHO",
                    "total" => 435,
                    "avance" => 245,
                    "pendiente" => 190,
                ],
                [
                    "nombre" => "APURIMAC",
                    "total" => 407,
                    "avance" => 249,
                    "pendiente" => 158,
                ],
                [
                    "nombre" => "HUANUCO",
                    "total" => 354,
                    "avance" => 219,
                    "pendiente" => 135,
                ],
                [
                    "nombre" => "LIMA",
                    "total" => 347,
                    "avance" => 218,
                    "pendiente" => 129,
                ],
                [
                    "nombre" => "PIURA",
                    "total" => 447,
                    "avance" => 298,
                    "pendiente" => 149,
                ],
                [
                    "nombre" => "TUMBES",
                    "total" => 51,
                    "avance" => 35,
                    "pendiente" => 16,
                ],
                [
                    "nombre" => "PASCO",
                    "total" => 263,
                    "avance" => 184,
                    "pendiente" => 79,
                ],
                [
                    "nombre" => "JUNIN",
                    "total" => 526,
                    "avance" => 371,
                    "pendiente" => 155,
                ],
                [
                    "nombre" => "LA LIBERTAD",
                    "total" => 333,
                    "avance" => 261,
                    "pendiente" => 72,
                ],
                [
                    "nombre" => "CALLAO",
                    "total" => 63,
                    "avance" => 54,
                    "pendiente" => 9,
                ],
                [
                    "nombre" => "MADRE DE DIOS",
                    "total" => 93,
                    "avance" => 85,
                    "pendiente" => 8,
                ],
                [
                    "nombre" => "AREQUIPA",
                    "total" => 269,
                    "avance" => 255,
                    "pendiente" => 14,
                ],
                [
                    "nombre" => "LAMBAYEQUE",
                    "total" => 196,
                    "avance" => 188,
                    "pendiente" => 8,
                ],
                [
                    "nombre" => "LIMA SUR",
                    "total" => 142,
                    "avance" => 140,
                    "pendiente" => 2,
                ],
            ]
        ];

        return response()->json($response);
    }
    
    public function reporte() {
        $where = "";
        
        $response = DB::table('establishment')
        ->join('format', 'establishment.id', '=', 'format.id_establecimiento')
        ->leftJoin('regimen_laboral', 'format.id_regimen_laboral', '=', 'regimen_laboral.id')
        ->leftJoin('condicion_profesional', 'format.id_condicion_profesional', '=', 'condicion_profesional.id')
        ->leftJoin('profesion', 'format.id_profesion_registrador', '=', 'profesion.id')
        ->leftJoin('tipo_documento', 'format.tipo_documento_registrador', '=', 'tipo_documento.id')
        ->select(
            DB::raw('LPAD(establishment.codigo, 8, 0) as codigo'),
           'establishment.institucion',  
           'establishment.nombre_eess',
           'establishment.departamento', 
           'establishment.provincia', 
           'establishment.distrito',
           'establishment.nombre_red', 
           'establishment.nombre_microred',
            DB::raw("(CASE WHEN format.nivel_atencion = '3' || establishment.categoria LIKE 'III%' THEN 'III' WHEN format.nivel_atencion = '2' || establishment.categoria LIKE 'II%' THEN 'II' WHEN format.nivel_atencion = '1' || establishment.categoria LIKE 'I%' THEN 'I' ELSE '-' END) AS nivel_atencion"),
           'establishment.categoria',
           'format.resolucion_categoria',
           'establishment.clasificacion',
           'establishment.tipo',
           'establishment.codigo_ue AS codigo_unidad_ejecutora',
           'establishment.unidad_ejecutora',
           'establishment.director_medico',
           'establishment.horario',
           'establishment.telefono',
           'format.inicio_funcionamiento', 
           'format.ultima_recategorizacion', 
           DB::raw("TIMESTAMPDIFF(YEAR, establishment.inicio_actividad, NOW()) AS antiguedad_anios"), 
           'establishment.quintil', 
           'establishment.pcm_zona',
           'establishment.frontera',
           'format.direccion',
           'format.referencia',
           'format.cota',
           'format.coordenada_utm_norte',
           'format.coordenada_utm_este',
           'format.seguridad_hospitalaria',
           'format.seguridad_resultado',
           'format.seguridad_fecha',
           'format.patrimonio_cultural',
           'format.fecha_emision',
           'format.numero_documento',
           'tipo_documento.nombre as tipo_documento_registrador',
           'format.fecha_emision_registrador',
           'format.doc_entidad_registrador',
           'format.nombre_registrador',
           'profesion.nombre as nombre_profesion_registrador',
           'format.cargo_registrador',
           'condicion_profesional.nombre as condicion_laboral',
           'regimen_laboral.nombre as regimen_laboral',
           'format.email_registrador',
           'format.movil_registrador'
        )->get();
                
        return response()->json($response);
    }
}