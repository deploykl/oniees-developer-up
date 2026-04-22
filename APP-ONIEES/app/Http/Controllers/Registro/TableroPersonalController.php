<?php
namespace App\Http\Controllers\Registro;
use App\Models\TableroPersonal;
use App\Models\TipoPersonal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class TableroPersonalController extends Controller
{
    public function index() {
        return view('registro.tablero-personal.index');
    }
    public function crear() {
        $tipo_personales = TipoPersonal::all();
        return view('registro.tablero-personal.crear', ['tipo_personales'=>$tipo_personales]);
    }
    public function editar($id) {
        $personal = TableroPersonal::find($id);
        $tipo_personales = TipoPersonal::all();
        return view('registro.tablero-personal.editar', ['personal'=>$personal, 'tipo_personales'=>$tipo_personales]);
    }
    public function guardar(Request $request) {
        try {
            $mensaje = 'Se guardo correctamente';
            $personal = new TableroPersonal();
            if ($request->input('id') != null && $request->input('id') != "" && $request->input('id') != "0") {
                $personal = TableroPersonal::find($request->input('id'));
                $mensaje = 'Se edito correctamente';
            }
            $personal->nombre = $request->input('nombre');
            $personal->id_tipo_personal = $request->input('id_tipo_personal');
            $personal->save();
            return [
                'status' => 'OK',
                'mensaje' => $mensaje,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}