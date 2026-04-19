<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Regiones;
use App\Models\Diresas;
use App\Models\Establishment;
use App\Models\TipoUsuario;
use App\Exports\Excel\UsersExport;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserResetPassword;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Password as RPassword;
use App\Models\TipoDocumento;
use GuzzleHttp\Client;

class UsersController extends Controller
{
 public function index()
{
    $users = User::all();
    $diresas = DB::table('diresa')->get(); // ← AGREGAR ESTA LÍNEA
    return view('admin.users.index', compact('users', 'diresas'));
}

    public function edit($id)
    {
        if ($id == null) {
            return "NO EXISTE EL USUARIO";
        }
        $user = User::find($id);
        if ($user == null) {
            return "NO EXISTE EL USUARIO";
        }
        if (Auth::user()->tipo_rol != "1") {
            if (Auth::user()->iddiresa != $user->iddiresa) {
                return "NO TIENE AUTORIZACION PARA MODIFICAR A ESTE USUARIO";
            }
        }
        $tipos = TipoUsuario::all();
        $diresas = DB::table('diresa')->get();
        $tipodocumentos = TipoDocumento::all();

        return view('admin.users.edit', [
            'tipos' => $tipos,
            'user' => $user,
            'diresas' => $diresas,
            'tipodocumentos' => $tipodocumentos
        ]);
    }

    public function add()
    {
        $user = new User();
        $tipos = TipoUsuario::all();
        $diresas = DB::table('diresa')->get();
        $tipodocumentos = TipoDocumento::all();

        return view('admin.users.create', [
            'tipos' => $tipos,
            'user' => $user,
            'diresas' => $diresas,
            'tipodocumentos' => $tipodocumentos
        ]);
    }

    public function list()
    {
        $users = User::all();
        return [
            "data" => $users
        ];
    }

    public function registerIndex()
    {
        return view('auth.register-index');
    }

    public function registerMinsa()
    {
        return view('auth.register-minsa');
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $iddiresa = $request->input('iddiresa') != null && strlen($request->input('iddiresa')) > 0 ? intval($request->input('iddiresa')) : 0;
        return (new UsersExport($search ?? "", $iddiresa))->download('users.xlsx');
    }

    public function deshabilitar2FA($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->two_factor_secret) {
            $usuario->forceFill([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
            ])->save();
        }

        return response()->json(['success' => true, 'message' => 'Autenticación 2FA deshabilitada']);
    }

    public function update_password(Request $request)
    {
        try {
            $user = User::find($request->input('id'));
            if ($user == null) {
                throw new \Exception('No se encuentra el usuario');
            }
            if ($request->input('password') != $request->input('password-repeat')) {
                throw new \Exception("Las claves son distintas en las dos cajas.");
            }

            $user->password = bcrypt($request->input('password'));

            $validator = \Validator::make($request->all(), [
                'password'  => ['required', 'string', new Password],
            ]);

            if ($validator->fails()) {
                $json_error = json_decode($validator->errors(), true);
                $error = implode($json_error["password"]);
                $error = str_replace("The password must be at least 8 characters.", "La clave debe tener al menos 8 caracteres.", $error);
                throw new \Exception($error);
            }

            $user->save();

            if (env('MAIL_ACTIVE') == true) {
                $mailable = new UserResetPassword('Notificacion de cambio de clave', env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_ADDRESS'), $user->email, $request->input('password'));
                Mail::to($user->email)->send($mailable);
            }

            return redirect()->route('users-index')
                ->with('toast_message', 'Contraseña actualizada correctamente')
                ->with('toast_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error');
        }
    }

public function delete(Request $request)
{
    try {
        $user = User::find($request->input('id'));
        if ($user == null) {
            throw new \Exception('No se encuentra el usuario');
        }

        $user->delete();
        return response()->json([
            'mensaje' => 'Se eliminó el Usuario',
            'status' => 'OK'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'mensaje' => $e->getMessage(),
            'status' => 'ERROR'
        ]);
    }
}

    public function resetPassword(Request $request)
    {
        try {
            $user = User::find($request->input('id'));
            if ($user == null) {
                throw new \Exception('No se encuentra el usuario');
            }

            if (env('MAIL_ACTIVE') == true) {
                $status = RPassword::sendResetLink(
                    $request->only('email')
                );
            } else {
                throw new \Exception('No esta activo el servicio Mail');
            }

            return redirect()->back()
                ->with('toast_message', 'Email de recuperación enviado')
                ->with('toast_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error');
        }
    }

    public function save(Request $request)
    {
        try {
            $user = new User();

            if (!$request->input('email')) {
                throw new \Exception('El email es obligatorio');
            }

            $usersemail = User::where('email', '=', $request->input('email'));
            if ($usersemail->count() > 0) {
                throw new \Exception('El email ya esta registrado');
            }

            if (!$request->input('idtiporol')) {
                throw new \Exception('Seleccione el Rol del Usuario');
            }

            if (!$request->input('idtipousuario') && $request->input('idtiporol') != "1") {
                throw new \Exception('Seleccione el Tipo de Usuario');
            }

            $user->fecha_emision = $request->input('fecha_emision');
            $user->id_tipo_documento = $request->input('id_tipo_documento');
            $user->documento_identidad = $request->input('documento_identidad');
            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->idtiporol = $request->input('idtiporol');
            $user->tipo_rol = $user->idtiporol;
            $user->idtipousuario = $request->input('idtipousuario');
            
            $validator = \Validator::make($request->all(), [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                $json_error = json_decode($validator->errors(), true);
                $error = implode($json_error["email"]);
                throw new \Exception($error);
            }
            
            $user->phone = $request->input('phone');
            $validator = \Validator::make($request->all(), [
                'phone' => 'min:9|max:9',
            ]);
            if ($validator->fails()) {
                $json_error = json_decode($validator->errors(), true);
                $error = str_replace("movil registrador", "celular del registrador", implode($json_error["phone"]));
                throw new \Exception($error);
            } else if (substr($user->phone, 0, 1) != "9") {
                throw new \Exception("El campo movil celular del registrador debe de comenzar con 9");
            }
            
            $user->cargo = $request->input('cargo');
            $user->unidad_funcional = "-";

            if ($request->input('iddiresa') != null) {
                $diresas_selected = $request->input('iddiresa');
                $diresas_regiones = Diresas::whereIn('id', $diresas_selected)->get();
                if ($diresas_regiones->count() == 0 && $user->tipo_rol != "1") {
                    throw new \Exception('Seleccione una Diresa');
                }

                if ($diresas_regiones->count() > 1) {
                    foreach ($diresas_regiones as $row) {
                        if ($row['multiple'] == 0) {
                            throw new \Exception('No se pueden crear el usuario con esas diresas en conjunto');
                            break;
                        }
                    }
                }

                $explode_regiones = [];
                foreach ($diresas_regiones as $row) {
                    $explode_regiones[] = $row['idregion'];
                }

                if ($diresas_regiones->count() > 0) {
                    $user->iddiresa = implode(",", $diresas_selected);
                    $user->region_id = implode(",", $explode_regiones);

                    $regiones = Regiones::select('nombre')->whereIn('id', $explode_regiones)->get();

                    $user->nombre_region = "";
                    if ($regiones->count() > 0) {
                        $region = $regiones->first();
                        $user->nombre_region = $regiones->count() == 1 ? $region->nombre : "VARIAS REGIONES";
                    }
                } else {
                    $user->iddiresa = 0;
                    $user->region_id = 0;
                    $user->nombre_region = "";
                }
            } else {
                $user->iddiresa = 0;
                $user->region_id = 0;
                $user->nombre_region = "";
            }

            $red = $request->input('red') != null ? trim($request->input('red')) : "";
            $user->red = $red;

            $microred = $request->input('microred') != null ? trim($request->input('microred')) : "";
            $user->microred = $microred;

            $idestablecimiento = $request->input('idestablecimiento') != null ? trim($request->input('idestablecimiento')) : "0";
            $establecimiento = new Establishment();
            if ($idestablecimiento != "0" && strlen($idestablecimiento) > 0) {
                $establecimiento = Establishment::find($idestablecimiento);
                if ($establecimiento == null) {
                    throw new \Exception('El establecimiento no existe.');
                }
                $user->idestablecimiento_user = $establecimiento->id;
                $user->nombre_eess = $establecimiento->codigo . " - " . $establecimiento->nombre_eess;
                if ($user->tipo_rol == 2) {
                    $user->tipo_rol = 3;
                }
            }

            $user->password = bcrypt($request->input('password'));

            $validator = \Validator::make($request->all(), [
                'password' => ['required', 'string', new Password],
            ]);
            if ($validator->fails()) {
                $json_error = json_decode($validator->errors(), true);
                $error = implode($json_error["password"]);
                $error = str_replace("The password must be at least 8 characters.", "La clave debe tener al menos 8 caracteres.", $error);
                throw new \Exception($error);
            }

            $user->state_id = $request->input('state_id');
            $user->user_created = Auth::user()->id;
            $user->save();

            if ($user->state_id == 2) {
                $permisos = DB::select("SELECT p.name FROM role_has_permissions rp INNER JOIN permissions p ON p.id=rp.permission_id WHERE rp.role_id=" . $user->tipo_rol);

                $AddPermissions = [];
                for ($x = 0; $x < count($permisos); $x++) {
                    $AddPermissions[] = $permisos[$x]->name;
                }

                if ($establecimiento != null && $establecimiento->id_institucion == 1) {
                    $permisos_essalud = DB::select("SELECT p.name FROM permissions p WHERE p.name LIKE 'ESSALUD%'");
                    for ($x = 0; $x < count($permisos_essalud); $x++) {
                        $AddPermissions[] = $permisos_essalud[$x]->name;
                    }
                }

                $user->givePermissionTo($AddPermissions);
            }

            if (env('MAIL_ACTIVE') == true) {
                $mailable = new UserResetPassword('Notificacion de registro de usuario', env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_ADDRESS'), $user->email, $request->input('password'));
                Mail::to($user->email)->send($mailable);
            }

            return redirect()->route('users-index')
                ->with('toast_message', 'Usuario creado correctamente')
                ->with('toast_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error')
                ->withInput();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::find($request->input('id'));
            if ($user == null) {
                throw new \Exception('No se encuentra el usuario');
            }

            if (Auth::user()->idtiporol != 1 && $user->idtiporol == 1) {
                throw new \Exception('No puede editar un Usuario de su mismo Rol o Superior');
            }

            if (!$request->input('idtiporol')) {
                throw new \Exception('Seleccione el Rol del Usuario');
            }

            if (!$request->input('idtipousuario') && $request->input('idtiporol') != "1") {
                throw new \Exception('Seleccione el Tipo de Usuario');
            }

            $tipo_rol = $user->tipo_rol;

            $user->fecha_emision = $request->input('fecha_emision');
            $user->id_tipo_documento = $request->input('id_tipo_documento');
            $user->documento_identidad = $request->input('documento_identidad');
            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->idtiporol = $request->input('idtiporol');
            $user->tipo_rol = $user->idtiporol;
            $user->idtipousuario = $request->input('idtipousuario');
            
            $validator = \Validator::make($request->all(), [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                $json_error = json_decode($validator->errors(), true);
                $error = implode($json_error["email"]);
                throw new \Exception($error);
            }

            $user->phone = $request->input('phone');
            $validator = \Validator::make($request->all(), [
                'phone' => 'min:9|max:9',
            ]);
            if ($validator->fails()) {
                $json_error = json_decode($validator->errors(), true);
                $error = str_replace("movil registrador", "celular del registrador", implode($json_error["phone"]));
                throw new \Exception($error);
            } else if (substr($user->phone, 0, 1) != "9") {
                throw new \Exception("El campo movil celular del registrador debe de comenzar con 9");
            }

            $user->cargo = $request->input('cargo');
            $user->unidad_funcional = "-";

            if ($request->input('iddiresa') != null) {
                $diresas_selected = $request->input('iddiresa');

                $diresas_regiones = Diresas::whereIn('id', $diresas_selected)->pluck('idregion');
                if ($diresas_regiones->count() == 0 && $user->tipo_rol != "1") {
                    throw new \Exception('Seleccione una Diresa');
                }

                $explode_regiones = [];
                foreach ($diresas_regiones as $row) {
                    $explode_regiones[] = $row;
                }

                if ($diresas_regiones->count() > 0) {
                    $user->iddiresa = implode(",", $diresas_selected);
                    $user->region_id = implode(",", $explode_regiones);

                    $regiones = Regiones::select('nombre')->whereIn('id', $explode_regiones)->get();

                    $user->nombre_region = "";
                    if ($regiones->count() > 0) {
                        $region = $regiones->first();
                        $user->nombre_region = $regiones->count() == 1 ? $region->nombre : "VARIAS REGIONES";
                    }
                } else {
                    $user->iddiresa = 0;
                    $user->region_id = 0;
                    $user->nombre_region = "";
                }
            } else {
                $user->iddiresa = 0;
                $user->region_id = 0;
                $user->nombre_region = "";
            }

            $red = $request->input('red') != null ? trim($request->input('red')) : "";
            $user->red = $red;

            $microred = $request->input('microred') != null ? trim($request->input('microred')) : "";
            $user->microred = $microred;

            $idestablecimiento = $request->input('idestablecimiento') != null ? trim($request->input('idestablecimiento')) : "0";
            $establecimiento = new Establishment();
            if ($idestablecimiento != "0" && strlen($idestablecimiento) > 0) {
                $establecimiento = Establishment::find($idestablecimiento);
                if ($establecimiento == null) {
                    throw new \Exception('El establecimiento no existe.');
                }
                $user->idestablecimiento_user = $establecimiento->id;
                $user->nombre_eess = $establecimiento->codigo . " - " . $establecimiento->nombre_eess;
                if ($user->tipo_rol == 2) {
                    $user->tipo_rol = 3;
                }
            } else {
                $user->idestablecimiento_user = null;
            }

            $user->user_updated = Auth::user()->id;
            $user->save();

            if ($user->state_id == 2 && $user->tipo_rol != $tipo_rol) {
                $permisos_essalud = DB::select("SELECT p.name FROM permissions p WHERE p.name LIKE 'ESSALUD%'");
                //ELIMINAR PERMISOS ANTERIORES
                $permisosRemove = DB::select("SELECT p.name FROM role_has_permissions rp INNER JOIN permissions p ON p.id=rp.permission_id WHERE rp.role_id=" . $tipo_rol);
                $RemovePermissions = [];
                for ($x = 0; $x < count($permisosRemove); $x++) {
                    $RemovePermissions[] = $permisosRemove[$x]->name;
                }
                $user->revokePermissionTo($RemovePermissions);

                //ASIGNAR PERMISOS NUEVOS
                $permisosAdd = DB::select("SELECT p.name FROM role_has_permissions rp INNER JOIN permissions p ON p.id=rp.permission_id WHERE rp.role_id=" . $user->tipo_rol);
                $AddPermissions = [];
                for ($x = 0; $x < count($permisosAdd); $x++) {
                    $AddPermissions[] = $permisosAdd[$x]->name;
                }
                if ($establecimiento != null && $establecimiento->id_institucion == 1) {
                    for ($x = 0; $x < count($permisos_essalud); $x++) {
                        $AddPermissions[] = $permisos_essalud[$x]->name;
                    }
                }
                $user->givePermissionTo($AddPermissions);
            }

            return redirect()->route('users-index')
                ->with('toast_message', 'Usuario actualizado correctamente')
                ->with('toast_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error')
                ->withInput();
        }
    }

    public function permissionRolUser()
    {
        try {
            $users = User::all();
            $permisos_essalud = DB::select("SELECT p.name FROM permissions p WHERE p.name LIKE 'ESSALUD%'");
            $permisosConfigurador = DB::select("SELECT p.name FROM role_has_permissions rp INNER JOIN permissions p ON p.id=rp.permission_id WHERE rp.role_id=" . env('ID_ROL_CONFIGURADOR', 0));

            foreach ($users as &$user) {
                $user->syncRoles([]);
                $user->syncPermissions([]);

                $AddPermissions = [];

                $permisos = DB::select("SELECT p.name FROM role_has_permissions rp INNER JOIN permissions p ON p.id=rp.permission_id WHERE rp.role_id=" . $user->tipo_rol);
                if (count($permisos) > 0) {
                    for ($x = 0; $x < count($permisos); $x++) {
                        $AddPermissions[] = $permisos[$x]->name;
                    }
                }

                if ($user->configurador == 1) {
                    for ($x = 0; $x < count($permisosConfigurador); $x++) {
                        $AddPermissions[] = $permisosConfigurador[$x]->name;
                    }
                }

                if ($user->idtipousuario == 2) {
                    for ($x = 0; $x < count($permisos_essalud); $x++) {
                        $AddPermissions[] = $permisos_essalud[$x]->name;
                    }
                } else {
                    if ($user->idestablecimiento_user != null && $user->idestablecimiento_user > 0) {
                        $establecimiento = Establishment::find($user->idestablecimiento_user);
                        if ($establecimiento != null && $establecimiento->id_institucion == 1) {
                            for ($x = 0; $x < count($permisos_essalud); $x++) {
                                $AddPermissions[] = $permisos_essalud[$x]->name;
                            }
                        }
                    }
                }

                if (count($AddPermissions) > 0) {
                    $user->givePermissionTo($AddPermissions);
                }
            }
            return redirect()->route('users-index')
                ->with('toast_message', 'Permisos actualizados correctamente')
                ->with('toast_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error');
        }
    }

    public function permission($id)
    {
        try {
            $user = User::find($id);
            $Permissions = DB::select('SELECT id, name, guard_name, module FROM permissions');

            $PermissionsUser = [];
            foreach ($user->getAllPermissions() as &$Permission) {
                $PermissionsUser[] = $Permission["id"];
            }

            $permisos = [];
            foreach ($Permissions as &$Permission) {
                $active = in_array($Permission->id, $PermissionsUser);
                $permisos[] = [
                    'id' => $Permission->id,
                    'name' => $Permission->name,
                    'guard_name' => $Permission->guard_name,
                    'module' => $Permission->module,
                    'active' => $active
                ];
            }

            if ($user->state_id != 2) {
                $user->state_id = 2;
                $user->save();
            }

            return view('admin.users.permisions', [
                'permissions' => $permisos,
                'user_id' => $id
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error');
        }
    }

    public function updatePermission(Request $request)
    {
        try {
            $user = User::find($request->input('id'));
            if ($user == null) {
                throw new \Exception('No se encuentra el usuario');
            }

            if (Auth::user()->tipo_rol != 1 && $user->tipo_rol == 1) {
                throw new \Exception('No puede editar un Usuario de su mismo Rol o Superior');
            }

            $AddPermissions = [];
            $RemovePermissions = [];
            if ($request->input('total') > 0) {
                for ($x = 0; $x < $request->input('total'); $x++) {
                    $permiso = explode("||", $request->input('permission' . $x));
                    if ($permiso[1] == "true") {
                        $AddPermissions[] = $permiso[0];
                    } else {
                        $RemovePermissions[] = $permiso[0];
                    }
                }
            }

            if (count($AddPermissions) > 0) {
                $user->givePermissionTo($AddPermissions);
            }

            if (count($RemovePermissions) > 0) {
                $user->revokePermissionTo($RemovePermissions);
            }

            return redirect()->back()
                ->with('toast_message', 'Permisos actualizados correctamente')
                ->with('toast_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_message', $e->getMessage())
                ->with('toast_type', 'error');
        }
    }

    function uPermission()
    {
        $users = User::all();
        foreach ($users as &$user) {
            $user->revokePermissionTo(Permission::all());
        }

        foreach ($users as &$user) {
            $permisos = DB::select("SELECT p.name FROM role_has_permissions rp INNER JOIN permissions p ON p.id=rp.permission_id WHERE rp.role_id=" . $user->tipo_rol);
            if (count($permisos) > 0) {
                $AddPermissions = [];
                for ($x = 0; $x < count($permisos); $x++) {
                    $AddPermissions[] = $permisos[$x]->name;
                }
                $user->givePermissionTo($AddPermissions);
            }
        }
        return redirect()->route('users-index')
            ->with('toast_message', 'Permisos sincronizados correctamente')
            ->with('toast_type', 'success');
    }

    public function createPermision()
    {
        $role = Role::find(1);

        $permission1 = Permission::create(['name' => 'SIGA - Inicio']);
        $role->givePermissionTo($permission1);

        $permission2 = Permission::create(['name' => 'SIGA GORE - Inicio']);
        $role->givePermissionTo($permission2);

        $permission3 = Permission::create(['name' => 'SIGA - Centro Quirurgico - Inicio']);
        $role->givePermissionTo($permission3);

        $permission4 = Permission::create(['name' => 'SIGA - Hospitalizacion Inicio']);
        $role->givePermissionTo($permission4);

        $permission5 = Permission::create(['name' => 'SIGA - Cuidados Intensivos - Inicio']);
        $role->givePermissionTo($permission5);

        $permission6 = Permission::create(['name' => 'SIGA - Patologia Clinica - Inicio']);
        $role->givePermissionTo($permission6);

        $permission7 = Permission::create(['name' => 'SIGA - Centro Obstetrico - Inicio']);
        $role->givePermissionTo($permission7);

        $permission8 = Permission::create(['name' => 'SIGA - Emergencia - Inicio']);
        $role->givePermissionTo($permission8);

        $permission9 = Permission::create(['name' => 'SIGA - Consulta Externa - Inicio']);
        $role->givePermissionTo($permission9);

        $permission10 = Permission::create(['name' => 'SIGA - Diagnostico por Imagenes - Inicio']);
        $role->givePermissionTo($permission10);

        $permission11 = Permission::create(['name' => 'SIGA - Almacen - Inicio']);
        $role->givePermissionTo($permission11);

        $permission12 = Permission::create(['name' => 'SIGA - Buscar Equipos - Inicio']);
        $role->givePermissionTo($permission12);

        return redirect()->back()
            ->with('toast_message', 'Permisos creados correctamente')
            ->with('toast_type', 'success');
    }

    public function test()
    {
        $client = new Client([
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Autorization' => 'Basic ' . env('APP_EETT_P_AUTORIZATION')
            ],
        ]);
        $response = $client->request('POST', env('APP_URL_P_TOKEN'), [
            'form_params' => [
                'username' => env('APP_EETT_P_USERNAME'),
                'password' => env('APP_EETT_P_PASSWORD'),
                'grant_type' => env('APP_EETT_P_GRAND_TYPE')
            ]
        ]);
        $response = $response->getBody()->getContents();

        return $response;
    }
public function listado_red(Request $request)
{
    try {
        $search = $request->input('search', '');
        $iddiresa = $request->input('iddiresa', '0');
        
        $query = DB::table('establishment')
            ->select('nombre_red as id', 'nombre_red as text')
            ->whereNotNull('nombre_red')
            ->where('nombre_red', '!=', '')
            ->groupBy('nombre_red');
        
        if ($search != '') {
            $query->where('nombre_red', 'LIKE', "%{$search}%");
        }
        
        // Filtrar por DIRIS seleccionada
        if ($iddiresa != '0' && $iddiresa != null && $iddiresa != '') {
            $diresas = explode(',', $iddiresa);
            $query->whereIn('iddiresa', $diresas);
        }
        
        $resultados = $query->limit(100)->get();
        
        return response()->json([
            'results' => $resultados,
            'pagination' => ['more' => false]
        ]);
    } catch (\Exception $e) {
        return response()->json(['results' => [], 'error' => $e->getMessage()]);
    }
}

public function listado_microred(Request $request)
{
    try {
        $search = $request->input('search', '');
        $iddiresa = $request->input('iddiresa', '0');
        $nombre_red = $request->input('nombre_red', '');
        
        $query = DB::table('establishment')
            ->select('nombre_microred as id', 'nombre_microred as text')
            ->whereNotNull('nombre_microred')
            ->where('nombre_microred', '!=', '')
            ->groupBy('nombre_microred');
        
        if ($search != '') {
            $query->where('nombre_microred', 'LIKE', "%{$search}%");
        }
        
        if ($iddiresa != '0' && $iddiresa != null) {
            $diresas = explode(',', $iddiresa);
            $query->whereIn('iddiresa', $diresas);
        }
        
        if ($nombre_red != '') {
            $query->where('nombre_red', $nombre_red);
        }
        
        $resultados = $query->limit(100)->get();
        
        return response()->json([
            'results' => $resultados,
            'pagination' => ['more' => false]
        ]);
    } catch (\Exception $e) {
        return response()->json(['results' => [], 'error' => $e->getMessage()]);
    }
}

public function listado_establecimiento(Request $request)
{
    try {
        $search = $request->input('search', '');
        $iddiresa = $request->input('iddiresa', '0');
        $nombre_red = $request->input('nombre_red', '');
        $nombre_microred = $request->input('nombre_microred', '');
        
        $query = DB::table('establishment')
            ->select('id', DB::raw("CONCAT(codigo, ' - ', nombre_eess) as text"))
            ->whereNotNull('nombre_eess');
        
        if ($search != '') {
            $query->where(function($q) use ($search) {
                $q->where('nombre_eess', 'LIKE', "%{$search}%")
                  ->orWhere('codigo', 'LIKE', "%{$search}%");
            });
        }
        
        if ($iddiresa != '0' && $iddiresa != null) {
            $diresas = explode(',', $iddiresa);
            $query->whereIn('iddiresa', $diresas);
        }
        
        if ($nombre_red != '') {
            $query->where('nombre_red', $nombre_red);
        }
        
        if ($nombre_microred != '') {
            $query->where('nombre_microred', $nombre_microred);
        }
        
        $resultados = $query->limit(100)->get();
        
        return response()->json([
            'results' => $resultados,
            'pagination' => ['more' => false]
        ]);
    } catch (\Exception $e) {
        return response()->json(['results' => [], 'error' => $e->getMessage()]);
    }
}
    


}