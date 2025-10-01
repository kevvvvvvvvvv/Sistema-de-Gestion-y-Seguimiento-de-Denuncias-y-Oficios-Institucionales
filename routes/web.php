<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BajaController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\ParticularController;
use App\Http\Controllers\ReporteDenunciasInstitucionController;
use App\Http\Controllers\ReporteDocumentosFaltantes;
use App\Http\Controllers\ReporteSeguimientoDenunciasController;
use App\Http\Controllers\ReporteProgresoOficioController;
use App\Http\Controllers\ReporteSeguimientoViajerosController;
use App\Http\Controllers\ReporteExpedienteCompleto;
use App\Http\Controllers\ReporteServidoresOmisosController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViajeroController;
use Spatie\Permission\Traits\HasRoles;


Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/test', [ProfileController::class, 'test']);

Route::get('dashboard/viajeros', function () {
    return Inertia::render('ViajerosDashboard');
})->middleware(['auth', 'verified'])->name('viajeros.dashboard');


Route::get('dashboard/expedientes', function () {
    return Inertia::render('ExpedientesDashboard');
})->middleware(['auth', 'verified'])->name('expedientes.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// GESTIÓN DE USUARIOS

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index')
    ->middleware('can:consultar users');

Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create')
    ->middleware('can:crear users');

Route::post('/users', [UserController::class, 'store'])
    ->name('users.store')
    ->middleware('can:crear users');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware('can:editar users');

Route::put('/users/{id}', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware('can:editar users');

Route::delete('/users/{id}', [UserController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('can:eliminar users');


// GESTIÓN DE VIAJEROS

Route::get('/viajeros',[ViajeroController::class,'index'])
    ->name('viajeros.index')
    ->middleware('can:consultar viajeros');

Route::get('/viajeros/create',[ViajeroController::class,'create'])
    ->name('viajeros.create')
    ->middleware('can:crear viajeros');

Route::post('/viajeros',[ViajeroController::class,'store'])
    ->name('viajeros.store')
    ->middleware('can:crear viajeros');

Route::get('/viajeros/{id}/edit',[ViajeroController::class,'edit'])
    ->name('viajeros.edit')
    ->middleware('can:editar viajeros');    

Route::put('/viajeros/{id}',[ViajeroController::class,'update'])
    ->name('viajeros.update')
    ->middleware('can:editar viajeros');

Route::delete('/viajeros/{id}',[ViajeroController::class,'destroy'])
    ->name('viajeros.destroy')
    ->middleware('can:eliminar viajeros');


//GESTIÓN DE PARTICULARES

Route::get('/particulares', [ParticularController::class, 'index'])
    ->name('particulares.index')
    ->middleware('can:consultar servidores');

Route::get('/particulares/create', [ParticularController::class, 'create'])
    ->name('particulares.create')
    ->middleware('can:crear servidores');

Route::post('/particulares', [ParticularController::class, 'store'])
    ->name('particulares.store')
    ->middleware('can:crear servidores');

Route::get('/particulares/{id}/edit', [ParticularController::class, 'edit'])
    ->name('particulares.edit')
    ->middleware('can:editar servidores');

Route::put('/particulares/{id}', [ParticularController::class, 'update'])
    ->name('particulares.update')
    ->middleware('can:editar servidores');

Route::delete('/particulares/{id}', [ParticularController::class, 'destroy'])
    ->name('particulares.destroy')
    ->middleware('can:eliminar servidores');

// GESTIÓN DE INSTITUCIONES

Route::get('/instituciones', [InstitucionController::class, 'index'])
    ->name('instituciones.index')
    ->middleware('can:consultar instituciones');

Route::get('/instituciones/create', [InstitucionController::class, 'create'])
    ->name('instituciones.create')
    ->middleware('can:crear instituciones');

Route::post('/instituciones', [InstitucionController::class, 'store'])
    ->name('instituciones.store')
    ->middleware('can:crear instituciones');

Route::get('/instituciones/{id}/edit', [InstitucionController::class, 'edit'])
    ->name('instituciones.edit')
    ->middleware('can:editar instituciones');

Route::put('/instituciones/{id}', [InstitucionController::class, 'update'])
    ->name('instituciones.update')
    ->middleware('can:editar instituciones');

Route::delete('/instituciones/{id}', [InstitucionController::class, 'destroy'])
    ->name('instituciones.destroy')
    ->middleware('can:eliminar instituciones');


// GESTIÓN DE DEPARTAMENTOS

Route::get('/departamentos', [DepartamentoController::class, 'index'])
    ->name('departamentos.index')
    ->middleware('can:consultar departamentos');

Route::get('/departamentos/create', [DepartamentoController::class, 'create'])
    ->name('departamentos.create')
    ->middleware('can:crear departamentos');

Route::post('/departamentos', [DepartamentoController::class, 'store'])
    ->name('departamentos.store')
    ->middleware('can:crear departamentos');

Route::get('/departamentos/{id}/edit', [DepartamentoController::class, 'edit'])
    ->name('departamentos.edit')
    ->middleware('can:editar departamentos');

Route::put('/departamentos/{id}', [DepartamentoController::class, 'update'])
    ->name('departamentos.update')
    ->middleware('can:editar departamentos');

Route::delete('/departamentos/{id}', [DepartamentoController::class, 'destroy'])
    ->name('departamentos.destroy')
    ->middleware('can:eliminar departamentos');


// GESTIÓN DE SERVIDORES PÚBLICOS

Route::get('/servidores', [ServidorController::class, 'index'])
    ->name('servidores.index')
    ->middleware('can:consultar servidores');

Route::get('/servidores/create', [ServidorController::class, 'create'])
    ->name('servidores.create')
    ->middleware('can:crear servidores');

Route::post('/servidores', [ServidorController::class, 'store'])
    ->name('servidores.store')
    ->middleware('can:crear servidores');

Route::get('/servidores/{id}/edit', [ServidorController::class, 'edit'])
    ->name('servidores.edit')
    ->middleware('can:editar servidores');

Route::put('/servidores/{id}', [ServidorController::class, 'update'])
    ->name('servidores.update')
    ->middleware('can:editar servidores');

Route::delete('/servidores/{id}', [ServidorController::class, 'destroy'])
    ->name('servidores.destroy')
    ->middleware('can:eliminar servidores');


// GESTIÓN DE EXPEDIENTES

Route::get('/expedientes', [ExpedienteController::class, 'index'])
    ->name('expedientes.index')
    ->middleware('can:consultar expedientes');

Route::get('/expedientes/create', [ExpedienteController::class, 'create'])
    ->name('expedientes.create')
    ->middleware('can:crear expedientes');

Route::post('/expedientes', [ExpedienteController::class, 'store'])
    ->name('expedientes.store')
    ->middleware('can:crear expedientes');

Route::get('/expedientes/{id}/edit', [ExpedienteController::class, 'edit'])
    ->where('id', '.*')
    ->name('expedientes.edit')
    ->middleware('can:editar expedientes');

Route::put('/expedientes/{id}', [ExpedienteController::class, 'update'])
    ->where('id', '.*')
    ->name('expedientes.update')
    ->middleware('can:editar expedientes');

Route::delete('/expedientes/{id}', [ExpedienteController::class, 'destroy'])
    ->where('id', '.*')
    ->name('expedientes.destroy')
    ->middleware('can:eliminar expedientes');


// GESTIÓN DE CONTROLES

Route::get('/controles', [ControlController::class, 'index'])
    ->name('controles.index')
    ->middleware('can:consultar controles');

Route::get('/controles/create', [ControlController::class, 'create'])
    ->name('controles.create')
    ->middleware('can:crear controles');

Route::post('/controles', [ControlController::class, 'store'])
    ->name('controles.store')
    ->middleware('can:crear controles');

Route::get('/controles/{id}/edit', [ControlController::class, 'edit'])
    ->name('controles.edit')
    ->middleware('can:editar controles');

Route::put('/controles/{id}', [ControlController::class, 'update'])
    ->name('controles.update')
    ->middleware('can:editar controles');

Route::delete('/controles/{id}', [ControlController::class, 'destroy'])
    ->name('controles.destroy')
    ->middleware('can:eliminar controles');


// GESTIÓN DE ROLES Y PERMISOS

Route::get('/roles', [RolesController::class, 'index'])
    ->name('roles.index')
    ->middleware('can:consultar roles');

Route::get('/roles/create', [RolesController::class, 'create'])
    ->name('roles.create')
    ->middleware('can:crear roles');

Route::post('/roles', [RolesController::class, 'store'])
    ->name('roles.store')
    ->middleware('can:crear roles');

Route::get('/roles/{id}/edit', [RolesController::class, 'edit'])
    ->name('roles.edit')
    ->middleware('can:editar roles');

Route::put('/roles/{id}', [RolesController::class, 'update'])
    ->name('roles.update')
    ->middleware('can:editar roles');

Route::delete('/roles/{id}', [RolesController::class, 'destroy'])
    ->name('roles.destroy')
    ->middleware('can:eliminar roles');


//GESTIÓN DE BAJAS
Route::get('/bajas', [BajaController::class, 'index'])
    ->name('bajas.index')
    ->middleware('can:consultar bajas');

Route::get('/bajas/create', [BajaController::class, 'create'])
    ->name('bajas.create')
    ->middleware('can:crear bajas');

Route::post('/bajas', [BajaController::class, 'store'])
    ->name('bajas.store')
    ->middleware('can:crear bajas');

Route::get('/bajas/{id}/edit', [BajaController::class, 'edit'])
    ->name('bajas.edit')
    ->middleware('can:editar bajas');

Route::put('/bajas/{id}', [BajaController::class, 'update'])
    ->name('bajas.update')
    ->middleware('can:editar bajas');

Route::delete('/bajas/{id}', [BajaController::class, 'destroy'])
    ->name('bajas.destroy')
    ->middleware('can:eliminar bajas'); 


//REPORTE DE SEGUIMIENTO DE DENUNCIAS
Route::get('/reportes/seguimiento-denuncias', [ReporteSeguimientoDenunciasController::class, 'showSeguimietoDenuncias'])
    ->name('reportes.seguimiento-deununcias');

//REPORTE DE DENUNCIAS POR INSTITUCION
Route::get('/reportes/denuncias-institucion',[ReporteDenunciasInstitucionController::class,'showDenunciasInstitucion'])
    ->name('reportes.denuncias-institucion');
Route::get('/reportes/denuncias-institucion/pdf', [ReporteDenunciasInstitucionController::class, 'descargarReporteDenunciasPdf'])
    ->name('reportes.denuncias.pdf');

//REPORTE DE PROGRESO DE OFICIOS POR DIA
Route::get('/reportes/progreso-oficio',[ReporteProgresoOficioController::class,'showProgresoOficio'])
    ->name('reportes.progreso-oficio');

//REPORTE DE PROGRESO DE OFICIOS POR DIA
Route::get('/reportes/seguimiento-viajeros',[ReporteSeguimientoViajerosController::class,'showSeguimientoViajeros'])
    ->name('reportes.seguimiento-viajeros');

//REPORTE DE DOCUMENTOS FALTANTES EN EXPEDIENTES
Route::get('/reportes/documentos-faltantes', [ReporteDocumentosFaltantes::class, 'showDocumentosFaltantes'])
    ->name('reportes.documentos-faltantes'); 
Route::get('/reportes/documentos-faltantes/generacionPDF', [ReporteDocumentosFaltantes::class, 'descargarReporteDocFaltPdf'])
    ->name('reportes.documentos.faltantes.pdf'); 

//REPORTE DE EXPEDIENTES COMPLETOS
Route::get('/reportes/expedientes-completos', [ReporteExpedienteCompleto::class, 'showExpedientes'])
    ->name('reportes.expedientes-completos'); 
Route::get('/reportes/expedientes-completos/generacionPDF', [ReporteExpedienteCompleto::class, 'descargarReporteExpeComPdf'])
    ->name('reportes.expedientes.completos.pdf'); 

//REPORTE DE SERVIDORES OMISOS
Route::get('/reportes/servidores-omisos', [ReporteServidoresOmisosController::class, 'showServidoresOmisos'])
    ->name('reportes.servidores-omisos'); 
Route::get('/reportes/servidores-omisos/generacionPDF', [ReporteServidoresOmisosController::class, 'descargarReporteServOmisoPdf'])
    ->name('reportes.servidores.omisos.pdf'); 

require __DIR__.'/auth.php';
