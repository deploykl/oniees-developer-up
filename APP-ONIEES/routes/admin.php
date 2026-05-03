<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\UsuariosConectadosController ;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PROTEGIDAS (REQUIEREN AUTENTICACIÓN)
// ============================================

// Rutas API (fuera del grupo admin)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/usuarios/conectados', [UsuariosConectadosController::class, 'index'])
        ->name('api.usuarios.conectados');
});

// Rutas del panel administrativo
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
        ->middleware('can:Usuarios - Eliminator');

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

   // Ruta para la vista de usuarios conectados
    Route::get('/usuarios/conectados', [UsuariosConectadosController::class, 'view'])
        ->name('usuarios.conectados');
});