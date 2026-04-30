<?php

namespace App\Http\Controllers\Infraestructura;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\FormatI;
use App\Models\FormatIOne;
use App\Models\FormatITwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EdificacionController extends Controller
{
    /**
     * Obtener todas las edificaciones de un establecimiento
     */
    public function index($idEstablecimiento)
    {
        $formatI = FormatI::where('id_establecimiento', $idEstablecimiento)->first();
        
        if (!$formatI) {
            return response()->json([]);
        }
        
        $edificaciones = FormatIOne::where('id_format_i', $formatI->id)
            ->with('acabados')
            ->get();
        
        return response()->json($edificaciones);
    }
    
    /**
     * Guardar nueva edificación
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $user = Auth::user();
            $establecimiento = Establishment::find($request->id_establecimiento);
            
            if (!$establecimiento) {
                throw new \Exception('Establecimiento no encontrado');
            }
            
            // Obtener o crear format_i
            $formatI = FormatI::where('id_establecimiento', $establecimiento->id)->first();
            if (!$formatI) {
                $formatI = new FormatI();
                $formatI->id_establecimiento = $establecimiento->id;
                $formatI->user_id = $user->id;
                $formatI->user_created = $user->id;
                $formatI->codigo_ipre = $establecimiento->codigo;
                $formatI->idregion = $establecimiento->idregion;
                $formatI->save();
            }
            
            // Crear nueva edificación
            $edificacion = new FormatIOne();
            $edificacion->id_format_i = $formatI->id;
            $edificacion->bloque = $request->bloque;
            $edificacion->pabellon = $request->pabellon;
            $edificacion->servicio = $request->servicio;
            $edificacion->nropisos = $request->nropisos;
            $edificacion->antiguedad = $request->antiguedad;
            $edificacion->ultima_intervencion = $request->ultima_intervencion;
            $edificacion->tipo_intervencion = $request->tipo_intervencion;
            $edificacion->observacion = $request->observacion;
            $edificacion->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Edificación agregada correctamente',
                'data' => $edificacion
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Actualizar edificación
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $edificacion = FormatIOne::find($id);
            
            if (!$edificacion) {
                throw new \Exception('Edificación no encontrada');
            }
            
            $edificacion->bloque = $request->bloque;
            $edificacion->pabellon = $request->pabellon;
            $edificacion->servicio = $request->servicio;
            $edificacion->nropisos = $request->nropisos;
            $edificacion->antiguedad = $request->antiguedad;
            $edificacion->ultima_intervencion = $request->ultima_intervencion;
            $edificacion->tipo_intervencion = $request->tipo_intervencion;
            $edificacion->observacion = $request->observacion;
            $edificacion->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Edificación actualizada correctamente',
                'data' => $edificacion
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Eliminar edificación
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $edificacion = FormatIOne::find($id);
            
            if (!$edificacion) {
                throw new \Exception('Edificación no encontrada');
            }
            
            // Eliminar también los acabados asociados
            FormatITwo::where('id_format_i_one', $id)->delete();
            $edificacion->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Edificación eliminada correctamente'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}