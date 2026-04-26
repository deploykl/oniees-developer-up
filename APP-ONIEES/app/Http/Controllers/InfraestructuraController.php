<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\FormatI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InfraestructuraController extends Controller
{
    /**
     * Mostrar formulario de infraestructura con datos del establecimiento
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $establecimiento = null;
        $showSelector = false;
        $codigoBuscar = null;
        
        // Si hay un código en la URL para buscar
        if ($request->get('codigo')) {
            $codigoBuscar = $request->get('codigo');
            $establecimiento = Establishment::where('codigo', $codigoBuscar)->first();
            
            if ($establecimiento) {
                session(['establecimiento_temp_id' => $establecimiento->id]);
            }
        }
        
        // Si hay un ID para cargar directamente
        if ($request->get('cargar')) {
            $establecimiento = Establishment::find($request->get('cargar'));
            if ($establecimiento) {
                session(['establecimiento_temp_id' => $establecimiento->id]);
            }
        }
        
        // Verificar si hay establecimiento en sesión temporal
        if (!$establecimiento && session('establecimiento_temp_id')) {
            $establecimiento = Establishment::find(session('establecimiento_temp_id'));
        }
        
        // Si el usuario tiene establecimiento asignado, usarlo
        if (!$establecimiento && $user->idestablecimiento_user) {
            $establecimiento = Establishment::find($user->idestablecimiento_user);
        }
        
        // Si aún no hay establecimiento, mostrar selector
        if (!$establecimiento) {
            $showSelector = true;
        }
        
        // USAR index.blade.php en lugar de edit.blade.php
        return view('infraestructura.index', [
            'establecimiento' => $establecimiento,
            'showSelector' => $showSelector,
            'user' => $user,
            'codigoBuscar' => $codigoBuscar
        ]);
    }
    
    /**
     * Buscar establecimiento por código (AJAX)
     */
    public function buscarEstablecimiento($codigo)
    {
        $establecimiento = Establishment::where('codigo', $codigo)->first();
        
        if (!$establecimiento) {
            return response()->json(['error' => 'Establecimiento no encontrado'], 404);
        }
        
        return response()->json([
            'id' => $establecimiento->id,
            'codigo' => $establecimiento->codigo,
            'nombre' => $establecimiento->nombre_eess,
            'region' => $establecimiento->region,
            'provincia' => $establecimiento->provincia,
            'distrito' => $establecimiento->distrito,
            'red' => $establecimiento->nombre_red,
            'microred' => $establecimiento->nombre_microred,
            'direccion' => $establecimiento->direccion,
            'telefono' => $establecimiento->telefono,
        ]);
    }
    
    /**
     * Guardar datos generales del establecimiento
     */
    public function save(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Buscar el establecimiento por ID
            $establecimiento = Establishment::find($request->id_establecimiento);
            
            if (!$establecimiento) {
                $establecimiento = new Establishment();
                $establecimiento->user_created = $user->id;
            } else {
                $establecimiento->user_updated = $user->id;
            }
            
            // Actualizar datos generales
            $establecimiento->codigo = $request->codigo_ipress;
            $establecimiento->institucion = $request->institucion;
            $establecimiento->nombre_eess = $request->nombre_eess;
            $establecimiento->region = $request->region;
            $establecimiento->provincia = $request->provincia;
            $establecimiento->distrito = $request->distrito;
            $establecimiento->nombre_red = $request->red;
            $establecimiento->nombre_microred = $request->microred;
            $establecimiento->nivel_atencion = $request->nivel_atencion;
            $establecimiento->categoria = $request->categoria;
            $establecimiento->direccion = $request->direccion;
            $establecimiento->telefono = $request->telefono;
            $establecimiento->numero_camas = $request->numero_camas;
            $establecimiento->director_medico = $request->director_medico;
            $establecimiento->horario = $request->horario;
            
            $establecimiento->save();
            
            // Limpiar sesión temporal
            session()->forget('establecimiento_temp_id');
            
            // Si el usuario no tenía establecimiento asignado y quiere asignarlo
            if (!$user->idestablecimiento_user && $request->has('asignar_a_mi')) {
                $user->idestablecimiento_user = $establecimiento->id;
                $user->save();
            }
            
            return redirect()->route('infraestructura.edit')
                ->with('success', 'Datos guardados correctamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }
}