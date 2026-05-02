<?php

namespace App\Http\Controllers\Infraestructura;

use App\Http\Controllers\Controller;
use App\Models\FormatIOne;
use App\Models\FormatITwo;
use Illuminate\Http\Request;

class AcabadoController extends Controller
{
    public function show($idEdificacion)
    {
        $acabado = FormatITwo::where('id_format_i_one', $idEdificacion)->first();
        return response()->json($acabado);
    }

   public function store(Request $request)
{
    try {
        $edificacion = FormatIOne::find($request->id_format_i_one);
        
        if (!$edificacion) {
            throw new \Exception('Edificación no encontrada');
        }

        $acabado = FormatITwo::updateOrCreate(
            ['id_format_i_one' => $request->id_format_i_one],
            [
                'id_format_i' => $edificacion->id_format_i,
                'pisos' => $request->pisos,
                'pisos_nombre' => $request->pisos_nombre ?? '',
                'pisos_estado' => $request->pisos_estado,
                'veredas' => $request->veredas,
                'veredas_nombre' => $request->veredas_nombre ?? '',
                'veredas_estado' => $request->veredas_estado,
                'zocalos' => $request->zocalos,
                'zocalos_nombre' => $request->zocalos_nombre ?? '',
                'zocalos_estado' => $request->zocalos_estado,
                'muros' => $request->muros,
                'muros_nombre' => $request->muros_nombre ?? '',
                'muros_estado' => $request->muros_estado,
                'techo' => $request->techo,
                'techo_nombre' => $request->techo_nombre ?? '',
                'techo_estado' => $request->techo_estado,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Acabados guardados correctamente',
            'data' => $acabado
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}