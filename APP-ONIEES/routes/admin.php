<?php

use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Registro\AguaSaneamientoController;
use App\Http\Controllers\Registro\EssaludInventarioController;
use App\Http\Controllers\Registro\TableroPersonalController;
use App\Http\Controllers\Registro\FidiController;
use App\Http\Controllers\Registro\FormatController;
use App\Http\Controllers\Registro\FormatIController;
use App\Http\Controllers\Registro\FormatIOneController;
use App\Http\Controllers\Registro\FormatITwoController;
use App\Http\Controllers\Registro\FormatIFilesController;
use App\Http\Controllers\Registro\FidiFilesController;
use App\Http\Controllers\Registro\FormatIFourTeenController;
use App\Http\Controllers\Registro\FormatIIController;
use App\Http\Controllers\Registro\FormatIIOneController;
use App\Http\Controllers\Registro\FormatIIThreeController;
use App\Http\Controllers\Registro\FormatIIIAController;
use App\Http\Controllers\Registro\FormatUPSSDirectaController;
use App\Http\Controllers\Registro\FormatUPSSDirectaOneController;
use App\Http\Controllers\Registro\FormatIIIBController;
use App\Http\Controllers\Registro\FormatIIIBOneController;
use App\Http\Controllers\Registro\FormatIIICController;
use App\Http\Controllers\Registro\FormatIIICOneController;
use App\Http\Controllers\Registro\FormatIIICTwoController;
use App\Http\Controllers\Registro\FormatIVController;
use App\Http\Controllers\Registro\FormatIVOneController;
use App\Http\Controllers\Registro\FormatIVTwoController;
use App\Http\Controllers\Registro\FormatIVThreeController;
use App\Http\Controllers\Registro\FormatIVFourController;
use App\Http\Controllers\Registro\FormatVController;
use App\Http\Controllers\Registro\FormatVOneController;
use App\Http\Controllers\Registro\FormatVTwoController;
use App\Http\Controllers\Registro\FormatVIController;
use App\Http\Controllers\Registro\FormatVIOneController;
use App\Http\Controllers\Registro\FormatVIIController;
use App\Http\Controllers\Registro\FormatVIIOneController;
use App\Http\Controllers\Registro\FormatVIITwoController;
use App\Http\Controllers\Registro\FormatVIIThreeController;
use App\Http\Controllers\Registro\FormatVIIFourController;
use App\Http\Controllers\Registro\PlantasController;
use App\Http\Controllers\Registro\PlantasOneController;
use App\Http\Controllers\Registro\TanquesController;
use App\Http\Controllers\Registro\GastosPPTOController;
use App\Http\Controllers\Registro\CostosController;
use App\Http\Controllers\Registro\SigaController;
use App\Http\Controllers\Registro\SigaRegionController;
use App\Http\Controllers\Registro\Siga\CentroQuirurgicoController;
use App\Http\Controllers\Registro\Siga\HospitalizacionController;
use App\Http\Controllers\Registro\Siga\CuidadosIntensivosController;
use App\Http\Controllers\Registro\Siga\PatologiaClinicaController;
use App\Http\Controllers\Registro\Siga\AlmacenController;
use App\Http\Controllers\Registro\Siga\DiagnosticoImagenesController;
use App\Http\Controllers\Registro\Siga\CentroObstetricoController;
use App\Http\Controllers\Registro\Siga\EmergenciaController;
use App\Http\Controllers\Registro\Siga\ConsultaExternaController;
use App\Http\Controllers\Registro\Siga\BuscarEquiposController;
use App\Http\Controllers\Registro\Siga\EquiposEstrategicosController;
use App\Http\Controllers\Registro\Siga\Region\RegionCentroQuirurgicoController;
use App\Http\Controllers\Registro\Siga\Region\RegionHospitalizacionController;
use App\Http\Controllers\Registro\Siga\Region\RegionCuidadosIntensivosController;
use App\Http\Controllers\Registro\Siga\Region\RegionPatologiaClinicaController;
use App\Http\Controllers\Registro\Siga\Region\RegionAlmacenController;
use App\Http\Controllers\Registro\Siga\Region\RegionDiagnosticoImagenesController;
use App\Http\Controllers\Registro\Siga\Region\RegionCentroObstetricoController;
use App\Http\Controllers\Registro\Siga\Region\RegionEmergenciaController;
use App\Http\Controllers\Registro\Siga\Region\RegionConsultaExternaController;
use App\Http\Controllers\Registro\Siga\Region\RegionBuscarEquiposController;
use App\Http\Controllers\Admin\ReniecController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\IpressController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\Admin\ProvincesController;
use App\Http\Controllers\Admin\DistrictsController;
use App\Http\Controllers\Admin\RRHHController;
use App\Http\Controllers\Admin\UPSSController;
use App\Http\Controllers\Admin\AmbientesController;
use App\Http\Controllers\Admin\PrincipiosController;
use App\Http\Controllers\Admin\MedicamentosController;
use App\Http\Controllers\Admin\EquiposController;
use App\Http\Controllers\Admin\SGSController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registro\TableroGerencialController;
use App\Http\Controllers\Admin\EstablismentsController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\DescargasController;
use App\Http\Controllers\Admin\UnidadEjecutoraController;
use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Registro\SeguimientoCancerController;
use App\Http\Controllers\Registro\FormatUPSSQuirurgicoController;
use App\Http\Controllers\Registro\FormatUPSSObstetricoController;
use App\Http\Controllers\Admin\FormularioInversionesController;
use App\Http\Controllers\Registro\SolicitudesController;
use App\Http\Controllers\Registro\TableroEjecutivoController;
use App\Http\Controllers\Registro\PlanMilDiagnosticoController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\PruebaController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\ArtisanController;
use App\Http\Controllers\Registro\RegistroEstadisticaController;
use App\Http\Controllers\Registro\TableroEjecutivoImportarController;
use App\Http\Controllers\Registro\InformacionEstadisticaController;
use App\Http\Controllers\Admin\DomPDFController;
use App\Http\Controllers\Admin\SpatiePdfController;
use App\Http\Controllers\Registro\PintadoController;
use App\Http\Controllers\Registro\SenializacionController;
use App\Http\Controllers\Registro\FichaTecnicaController;
use App\Http\Controllers\Registro\EncuestaController;
use App\Http\Controllers\Registro\MCMController;
use App\Http\Controllers\Registro\WebPageController;


// ============================================
// RUTAS PROTEGIDAS (REQUIEREN AUTENTICACIÓN)
// ============================================
//prefix para la ruta 
Route::middleware(['auth'])->prefix('admin')->group(function () {

    /* USUARIOS */
    Route::get('/users', [UsersController::class, 'index'])
        ->name('users-index')
        ->middleware('can:Usuarios - Inicio');

    Route::get('/users/list', [UsersController::class, 'list'])
        ->name('users-list')
        ->middleware('can:Usuarios - Inicio');

    Route::post('/users/save', [UsersController::class, 'save'])
        ->name('users-save')
        ->middleware('can:Usuarios - Crear');

    Route::get('/users/add', [UsersController::class, 'add'])
        ->name('users-add')
        ->middleware('can:Usuarios - Crear');

    Route::get('/users/edit/{id?}', [UsersController::class, 'edit'])
        ->name('users-edit')
        ->middleware('can:Usuarios - Editar');

    Route::post('/users/update', [UsersController::class, 'update'])
        ->name('users-update')
        ->middleware('can:Usuarios - Editar');

    Route::post('/users/delete', [UsersController::class, 'delete'])
        ->name('users-delete')
        ->middleware('can:Usuarios - Eliminar');

    Route::post('/users/reset-password', [UsersController::class, 'resetPassword'])
        ->name('users-reset-password')
        ->middleware('can:Usuarios - Resetear Clave');

    Route::get('/users/edit/{id}/permission', [UsersController::class, 'permission'])
        ->name('users-edit-permission')
        ->middleware('can:Usuarios - Editar Permisos');

    Route::post('/users/edit/permission', [UsersController::class, 'updatePermission'])
        ->name('users-update-permission')
        ->middleware('can:Usuarios - Editar Permisos');

    // Estas rutas no requieren permisos específicos
    Route::get('/users/listado-red', [UsersController::class, 'listado_red'])->name('users-listado-red');
    Route::get('/users/listado-microred', [UsersController::class, 'listado_microred'])->name('users-listado-microred');
    Route::get('/users/listado-establecimiento', [UsersController::class, 'listado_establecimiento'])->name('users-listado-establecimiento');
    Route::post('/usuarios/{id}/deshabilitar-2fa', [UsersController::class, 'deshabilitar2FA'])->name('usuarios.deshabilitar2fa');

    Route::get('/debug-permissions', function () {
        $user = auth()->user();
        if (!$user) {
            return 'No hay usuario autenticado';
        }

        return [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'tipo_rol' => $user->tipo_rol,
            'has_role_admin' => $user->hasRole('admin'),
            'direct_permissions' => $user->getDirectPermissions()->pluck('name'),
            'all_permissions' => $user->getAllPermissions()->pluck('name'),
            'can_users_index' => $user->can('Usuarios - Inicio'),
            'can_view_users' => $user->can('Usuarios - Inicio'),
        ];
    })->middleware(['auth']);

    Route::get('/tablero-gerencial', [TableroGerencialController::class, 'index'])->name('tablero-gerencial-index');
    // Agregar estas rutas para el tablero gerencial
    Route::get('/tablero-gerencial', [TableroGerencialController::class, 'index'])->name('tablero-gerencial-index');
    Route::post('/busqueda-codigo-margesi-tablero', [TableroGerencialController::class, 'busquedaCodigoMargesi'])->name('busqueda-codigo-margesi-tablero');
    Route::post('/tablero-gerencial-list-group', [TableroGerencialController::class, 'listgroup'])->name('tablero-gerencial-list-group');
    Route::post('/tabla-general-detalle-estado', [TableroGerencialController::class, 'tabla_general_detalle_estado'])->name('tabla-general-detalle-estado');
    Route::post('/tabla-general-detalle-pagination', [TableroGerencialController::class, 'tabla_general_detalle_pagination'])->name('tabla-general-detalle-pagination');
    Route::get('/establecimiento-search/{codigo}', [TableroGerencialController::class, 'establecimientoSearch'])->name('establecimiento-search');
    Route::get('/tabla-general-personal-tipo/{tipo}/{idregion}/{cod_ogei}', [TableroGerencialController::class, 'tabla_gereral_personal_tipo'])->name('tabla-general-personal-tipo');
    Route::post('/encode-tablero-gerencial', [TableroGerencialController::class, 'encode_tablero_gerencial'])->name('encode-tablero-gerencial');
    Route::get('/tabla-general-detalle-export/{where}', [TableroGerencialController::class, 'tabla_general_detalle_export'])->name('tabla-general-detalle-export');
    Route::post('/encode-recursos-humanos', [TableroGerencialController::class, 'encode_recursos_humanos'])->name('encode-recursos-humanos');
    Route::get('/tabla-general-personal-tipo-export/{tipo}/{where}', [TableroGerencialController::class, 'tabla_gereral_personal_tipo_export'])->name('tabla-general-personal-tipo-export');
    // Ruta para guest (sin login)
    Route::post('/busqueda-codigo-margesi-tablero-guest', [TableroGerencialController::class, 'busquedaCodigoMargesiGuest'])->name('busqueda-codigo-margesi-tablero-guest');

    Route::get('/formato-0/{codigo?}', [FormatController::class, 'index'])->name('formato-0');
    Route::post('/formato-0/save', [FormatController::class, 'save'])->name('format-0-save');
    Route::get('/formato-0/search/{codigo?}', [FormatController::class, 'search'])->name('format-0-search');

    /*FORMATO I*/
    Route::get('/formato-I/{codigo?}', [FormatIController::class, 'index'])->name('formato-i');
    Route::get('/formato-I-test/{codigo?}', [FormatIController::class, 'test'])->name('formato-i-test');
    Route::post('/formato-I/save', [FormatIController::class, 'save'])->name('format-i-save');
    Route::get('/formato-I/search/{codigo?}', [FormatIController::class, 'search'])->name('format-i-search');
    Route::middleware('cors')->get('/reniec/searchDni/{fechaEmision?}/{nroDocumento?}', [ReniecController::class, 'searchDni'])->name("searchDni");
    Route::middleware('cors')->get('/reniec/dni/{nroDocumento?}', [ReniecController::class, 'search_dni'])->name("search-dni");
    Route::middleware('cors')->get('/reniec/searchRUC/{nroDocumento?}', [ReniecController::class, 'searchRUC'])->name("searchRUC");
    Route::get('/provincias-region/{idregion?}', [ProvincesController::class, 'list'])->name('provincias-region');
    Route::get('/distritos-provincia/{province_id?}', [DistrictsController::class, 'list'])->name('distritos-provincia');
});
