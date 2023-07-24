<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CronController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MensajesController;
use App\Http\Controllers\Panel\PermissionsController;
use App\Http\Controllers\Panel\RolesController;
use App\Http\Controllers\Panel\UsuariosController;
use App\Http\Controllers\Panel\SedesController;
use App\Http\Controllers\Panel\AsignacionesDiariaController;
use App\Http\Controllers\Panel\AsistenciasController;
use App\Http\Controllers\Panel\CategoriasController;
use App\Http\Controllers\Panel\ComprasController;
use App\Http\Controllers\Panel\CronogramaController;
use App\Http\Controllers\Panel\FichasController;
use App\Http\Controllers\Panel\PdfController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\PacientesController;
use App\Http\Controllers\Panel\ProductosController;
use App\Http\Controllers\Panel\ProductosDetallesController;
use App\Http\Controllers\Panel\ProveedoresController;
use App\Http\Controllers\Panel\ReportesController;
use App\Http\Controllers\Panel\SolicitudesController;
use App\Http\Controllers\Panel\UbigeoController;
use App\Http\Controllers\Panel\UnidadesController;
use App\Http\Controllers\Panel\CalendarioController;
use App\Http\Controllers\Panel\PuntoVentaController;
use App\Http\Controllers\Panel\Fechas_listController;
use App\Http\Controllers\Panel\HorarioSedesController;
use App\Http\Controllers\Panel\HojadeRutaController;


use App\Http\Controllers\Panel\UsuarioArchivos;
use App\Http\Controllers\Panel\WhatsappController;
use App\Models\Asignacionesdiarias;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route Components
Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/full', [StaterkitController::class, 'layout_full'])->name('layout-full');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
//CreateNewUser
/*Route::group(['prefix' => 'auth'], function () {
	Route::get('login', [LoginController::class, 'index'])->name('auth-login');
	Route::post('login', [AuthController::class, 'login'])->name('auth-login-verify');
	Route::get('register', [LoginController::class, 'register'])->name('auth-register');
	Route::post('register', [AuthController::class, 'register'])->name('auth-register-verify');
	Route::get('forgot-password', [LoginController::class, 'recuperar_contrasenia'])->name('auth-forgot-password');
});*/


Route::get('/', [HomeController::class, 'index'])->name('initial');
Route::get('/clear/route', [ConfigController::class, 'clearRoute']);

Route::get('/cron/productos', [CronController::class, 'productos_stock'])->name('productos-stock');
Route::get('/cron/whatsapp', [CronController::class, 'suscription'])->name('wsp-suscription');
Route::post('/cron/whatsapp', [CronController::class, 'whatsapp'])->name('wsp-reponse')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/route-cache', function () {
	$exitCode = Artisan::call('route:cache');
	return 'Routes cache cleared';
});

Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	return "Cache is cleared";
});

Route::get('sendwsp', [MensajesController::class, 'sendAsignacionDiaria'])->name('sendasignaciondiaria');
Route::get('sendwspfix', [MensajesController::class, 'sendAsignacionDiaria2'])->name('sendasignaciondiaria2');
Route::group(['prefix' => 'panel', 'middleware' => 'auth'], function () {
	Route::get('home', [HomeController::class, 'home'])->name('home');
	Route::get('roles', [RolesController::class, 'show'])->name('roles.show');
	Route::get('permissions', [PermissionsController::class, 'show'])->name('permissions.show');

	//CRUD FICHAS DE ATENCIÓN
	Route::get('fichas-atencion', [FichasController::class, 'index'])->name('fichas.index');
	Route::get('fichas-atencion/nueva', [FichasController::class, 'nueva'])->name('fichas.nueva');
	Route::get('fichas-atencion/listado', [FichasController::class, 'list'])->name('fichas.list');
	Route::post('fichas-atencion/create', [FichasController::class, 'create'])->name('ficha.create');
	Route::get('fichas-atencion/data/{ficha?}', [FichasController::class, 'data'])->name('ficha.data');
	Route::put('fichas-atencion/update/{ficha?}', [FichasController::class, 'update'])->name('ficha.update');

	Route::get('fichas-atencion/show/{ficha?}', [FichasController::class, 'show'])->name('ficha.show');

	//CRUD USUARIOS
	Route::get('usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
	Route::get('usuarios/listado', [UsuariosController::class, 'list'])->name('usuarios.list');
	Route::get('usuario/data/{user?}', [UsuariosController::class, 'data'])->name('usuarios.data');

	Route::get('usuario/show/{user_id?}', [UsuariosController::class, 'show'])->name('usuario.show');
	Route::post('usuario/create', [UsuariosController::class, 'create'])->name('usuario.create');
	Route::put('usuario/update/{user?}', [UsuariosController::class, 'update'])->name('usuario.update');
	Route::post('usuario/sendbienvenida/{user?}', [UsuariosController::class, 'sendbienvenida'])->name('usuario.sendbienvenida');
	Route::put('usuario/delete/{user?}', [UsuariosController::class, 'delete'])->name('usuario.delete');

	
	//CRUD SEDES
	Route::get('sedes', [SedesController::class, 'index'])->name('sedes.index');
	Route::get('sedes/listado', [SedesController::class, 'list'])->name('sedes.list');
	Route::post('sede/update/{sede?}', [SedesController::class, 'update'])->name('sede.update');
	Route::post('sede/create', [SedesController::class, 'create'])->name('sede.create');
	Route::get('sedes/show/{sede_id?}', [SedesController::class, 'show'])->name('sedes.show');
	
	// sedesProDetalle.blade
	Route::get('sedes/products/{sede_id?}', [SedesController::class, 'products'])->name('products.show');
	Route::get('sedes/listar/{sede_id?}', [SedesController::class, 'listar'])->name('sedes.listare');
	Route::put('sede/delete/{sede?}', [SedesController::class, 'delete'])->name('sede.delete');


	//CRUD ASIGNACION DIARIA
	Route::get('asignacion-diaria', [AsignacionesDiariaController::class, 'index'])->name('asignacionDiaria.index');
	//Route::get('asignacion-diaria/listado', [AsignacionesDiariaController::class, 'list'])->name('asignaciondiaria.list');
	Route::post('asignacion-diaria/create', [AsignacionesDiariaController::class, 'create'])->name('asignaciondiaria.create');
	Route::post('asignacion-diaria/create2', [AsignacionesDiariaController::class, 'create2'])->name('asignaciondiaria.create2');
	//Route::get('asignacion-diaria/users/{asignacion?}', [AsignacionesDiariaController::class, 'data'])->name('asignaciondiaria.data');
	Route::get('asignacion-diaria/data/{asignacion?}', [AsignacionesDiariaController::class, 'users'])->name('asignaciondiaria.users');
	Route::get('asignacion-diaria/datos/{usuarioid?}', [AsignacionesDiariaController::class, 'datos'])->name('asignaciondiaria.datos');
	//Route::get('asignacion-diaria/sedes/{usuarioid?}', [AsignacionesDiariaController::class, 'sedes'])->name('asignaciondiaria.sedes');
	//Route::put('asignacion-diaria/update/{asignacion?}', [AsignacionesDiariaController::class, 'update'])->name('asignaciondiaria.update');
	//Route::put('asignacion-diaria/delete/{asignacion?}', [AsignacionesDiariaController::class, 'delete'])->name('asignaciondiaria.delete');
	Route::get('asignacion-diaria/getfecha/{fecha?}', [AsignacionesDiariaController::class, 'getfecha'])->name('asignaciondiaria.getfecha');
	Route::get('usuarioSedes/{sede?}', [HorarioSedesController::class, 'getsede'])->name('usuarioSedes.getsede');
	Route::post('asignacion-diaria/getusersbysede',[AsignacionesDiariaController::class,'getUsersBySede'])->name('asignaciondiaria.usersbysede');
	


	//CRUD INGRESOS-SALIDA
	Route::get('asistencias', [AsistenciasController::class, 'index'])->name('asistencias.index');
	Route::get('asistencias/date/{fecha?}', [AsistenciasController::class, 'asistenciafecha'])->name('asistencia.date');
	Route::get('asistencias/listado', [AsistenciasController::class, 'list'])->name('asistencias.list');
	Route::post('asistencia/create', [AsistenciasController::class, 'create'])->name('asistencia.create');
	Route::get('asistencia/data/{asistencia?}', [AsistenciasController::class, 'data'])->name('asistencia.data');

	//CRUD PACIENTE
	Route::get('paciente/data/{document?}/{paciente?}', [PacientesController::class, 'data'])->name('paciente.data');

	//CRUD REPORTES
	Route::get('reportes', [ReportesController::class, 'index'])->name('reportes.index');
	Route::get('reporte/disponibilidad/{range?}', [ReportesController::class, 'reporte_disponibilidad'])->name('reporte.disponibilidad');
	Route::get('reporte/atenciones-topico/{sedes?}/{range?}', [ReportesController::class, 'reporte_atenciones_topico'])->name('reporte.atencionestopico');
	Route::get('reporte/horas-trabajadas/{sedes?}/{range?}', [ReportesController::class, 'reporte_horastrabajadas_topico'])->name('reporte.horastrabajadas');

	//UBIGEO
	Route::get('ubigeo/{padre?}', [UbigeoController::class, 'provincias'])->name('ubigeo.padre');
	//Route::get('ubigeo/provincias/{departamento?}', [UbigeoController::class, 'provincias'])->name('ubigeo.padre');



	//CRONOGRAMA
	Route::get('cronograma', [CronogramaController::class, 'index'])->name('cronograma.index');
	Route::post('cronograma/disponibilidad', [CronogramaController::class, 'disponibilidad'])->name('cronograma.disponibilidad');
	Route::post('cronograma/create', [CronogramaController::class, 'create'])->name('cronograma.create');
	Route::get('cronograma/data', [CronogramaController::class, 'data'])->name('cronograma.data');
	Route::get('cronograma/datamihorario', [CronogramaController::class, 'datamihorario'])->name('cronograma.datamihorario');
	Route::post('cronograma/delete/{cronograma?}', [CronogramaController::class, 'delete'])->name('cronograma.delete');
	Route::get('cronograma/dataday/{day?}', [CronogramaController::class, 'dataday'])->name('cronograma.dataday');
	Route::get('cronograma/event/{event?}/{id?}', [CronogramaController::class, 'event'])->name('cronograma.event');
	Route::get('cronograma/fecha_asignada/{fecha?}/{id?}', [CronogramaController::class, 'fecha_asignada'])->name('cronograma.fecha_asignada');
	Route::put('cronograma/update/{usercontroller?}', [CronogramaController::class, 'update'])->name('cronograma.update');


	//ARCHIVOS
	Route::get('hojasderuta', [HojadeRutaController::class, 'index'])->name('hojasderuta.index');
	Route::get('hojasderuta/list', [HojadeRutaController::class, 'list'])->name('hojasderuta.list');
	Route::post('hojasderuta/delete/{hoja?}', [HojadeRutaController::class, 'delete'])->name('hojaderuta.delete');
	Route::get('hojaderuta/show/{hoja?}', [HojadeRutaController::class, 'show'])->name('hojaderuta.show');
	Route::get('hojaderuta_show/show_eye/{hoja?}', [HojadeRutaController::class, 'show_eye'])->name('hojaderuta_show.show_eye');
	Route::post('hojaderuta/create', [HojadeRutaController::class, 'create'])->name('hojaderuta.create');
	Route::get('generatePDF/{hoja_id}', [HojadeRutaController::class, 'generatePDF'])->name('generatePDF.show');
	// Route::post('hojaderuta/generarPdf', [HojadeRutaController::class, 'generatePDF'])->name('hojaderuta.generatePDF');
	// Route::get('generate-pdf', [HojadeRutaController::class, 'Imprimir']);
	// Route::View('/','welcome');


	Route::post('hojaderuta/guardar', [HojadeRutaController::class, 'saveCheck'])->name('hojaderuta.guardar');
	Route::post('hojaderuta/updateCheck/{checkId?}', [HojadeRutaController::class,'updateCheck'])->name('hojaderuta.updateCheck');
	Route::post('hojaderuta', [HojadeRutaController::class, 'uploadImagen'])->name('hojaderuta.uploadImagen');
	Route::post('hojaderuta/update/{hoja?}', [HojadeRutaController::class, 'update'])->name('hojaderuta.update');


	Route::get('myPDF', [PdfController::class, 'index'])->name('myPDF.index');



	// Route::get('usuario/show/{user_id?}', [UsuariosController::class, 'show'])->name('usuario.show');



	//CALENDARIO
	Route::get('calendario', [CalendarioController::class, 'index'])->name('calendario.index');
	Route::post('calendario/list/{id?}', [CalendarioController::class, 'list'])->name('calendario.list');
	Route::post('calendario/save', [CalendarioController::class, 'save'])->name('calendario.save');
	//CALENDARIO

	//FECHASLISTA
	Route::get('horarios', [Fechas_listController::class, 'index'])->name('horarios.index');
	Route::get('horarios/listar', [Fechas_listController::class, 'listar'])->name('horarios.listar');
	Route::post('horarios/save', [Fechas_listController::class, 'save'])->name('horarios.save');
	Route::get('horarios/getFecha/{id?}', [Fechas_listController::class, 'getFecha'])->name('horarios.getFecha');
	Route::post('horarios/update', [Fechas_listController::class, 'update'])->name('horarios.update');
	Route::post('horarios/delete/{id?}', [Fechas_listController::class, 'delete'])->name('horarios.delete');


	Route::put('archivos/delete/{archivo?}/{usuarioid?}', [UsuarioArchivos::class, 'delete'])->name('archivos.delete');

	//WHATSAPP - MENSAJES

	Route::get('mensajes', [WhatsappController::class, 'index'])->name('mensajes.index');
	Route::get('mensajes/chat/{user?}', [WhatsappController::class, 'chat'])->name('mensajes.chat');
	Route::post('mensajes/send', [WhatsappController::class, 'send'])->name('mensajes.send');

	//PROVEEDORES
	Route::get('proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');
	Route::get('proveedores/listado', [ProveedoresController::class, 'list'])->name('proveedores.list');
	Route::post('proveedores/submit', [ProveedoresController::class, 'submit'])->name('proveedor.submit');
	Route::put('proveedores/delete/{proveedor?}', [ProveedoresController::class, 'delete'])->name('proveedor.delete');
	Route::get('proveedores/data/{proveedor?}', [ProveedoresController::class, 'data'])->name('proveedor.data');

	//Unidades
	Route::get('unidades', [UnidadesController::class, 'index'])->name('unidades.index');
	Route::get('unidades/listado', [UnidadesController::class, 'list'])->name('unidades.list');
	Route::post('unidades/submit', [UnidadesController::class, 'submit'])->name('unidad.submit');
	Route::put('unidades/delete/{unidad?}', [UnidadesController::class, 'delete'])->name('unidad.delete');
	Route::get('unidades/data/{unidad?}', [UnidadesController::class, 'data'])->name('unidad.data');

	//Categorias
	Route::get('categorias', [CategoriasController::class, 'index'])->name('categorias.index');
	Route::get('categorias/listado', [CategoriasController::class, 'listarCategorias'])->name('categorias.list');
	Route::get('categorias/{categoria?}', [CategoriasController::class, 'data'])->name('categoria.data');
	Route::post('categorias', [CategoriasController::class, 'create'])->name('categoria.create');
	Route::post('categorias/{categoriaID?}', [CategoriasController::class, 'update'])->name('categoria.update');
	

	//PRODUCTOS
	Route::get('productos', [ProductosController::class, 'index'])->name('productos.index');
	Route::get('productos/listado', [ProductosController::class, 'listarProductos'])->name('productos.list');
	Route::get('productos/{producto?}', [ProductosController::class, 'data'])->name('producto.data');
	Route::post('productos', [ProductosController::class, 'create'])->name('producto.create');
	Route::post('producto/{Idproducto?}', [ProductosController::class, 'delete'])->name('producto.delete');
	Route::post('productos/{productoId?}', [ProductosController::class, 'update'])->name('producto.update');
	Route::get('productos/search', [ProductosController::class, 'search'])->name('producto.search');


	//PUNTO DE VENTA
	Route::get('puntoventa', [PuntoVentaController::class, 'index'])->name('puntoventa.index');
	Route::get('puntoventa/vender', [PuntoVentaController::class, 'ventas'])->name('realizar.venta');
	Route::get('puntoventa/venta/{ventaId?}', [PuntoVentaController::class, 'showVenta'])->name('showVenta.venta');
	Route::get('puntoventa/pdf/', [PuntoVentaController::class, 'generarPdf'])->name('generar.pdf');
	


	Route::get('puntoventa/listado', [PuntoVentaController::class, 'listarVentas'])->name('puntoventa.list');
	Route::get('puntoventa/search', [PuntoVentaController::class, 'search'])->name('productoVenta.search');
	Route::get('puntoventa/{productoID?}', [PuntoVentaController::class, 'data'])->name('puntoventa.data');
	Route::post('puntoventa/venta', [PuntoVentaController::class, 'create'])->name('puntoventa.create');



	//PRODUCTOS DETALLES 
	Route::get('productosDetalles', [ProductosDetallesController::class, 'index'])->name('productosDetalles.index');
	Route::get('productosDetalles/listado', [ProductosDetallesController::class, 'list'])->name('productosDetalles.list');
	Route::post('productosDetalles/submit', [ProductosDetallesController::class, 'submit'])->name('productosDetalles.submit');
	Route::put('productosDetalles/delete/{producto?}', [ProductosDetallesController::class, 'delete'])->name('productosDetalles.delete');
	Route::get('productosDetalles/data/{producto?}', [ProductosDetallesController::class, 'data'])->name('productosDetalles.data');


	//Compras
	Route::get('compras', [ComprasController::class, 'index'])->name('compras.index');
	Route::get('compras/nuevo', [ComprasController::class, 'nuevo'])->name('compra.new');
	Route::get('compras/listado', [ComprasController::class, 'list'])->name('compras.list');
	Route::post('compras/submit', [ComprasController::class, 'submit'])->name('compras.submit');
	Route::put('compras/delete/{compra?}', [ComprasController::class, 'delete'])->name('compra.delete');
	Route::get('compras/data/{compra?}', [ComprasController::class, 'data'])->name('compra.data');

	//Solicitudes
	Route::get('solicitudes', [SolicitudesController::class, 'index'])->name('solicitudes.index');
	Route::get('solicitudes/listado', [SolicitudesController::class, 'list'])->name('solicitudes.list');
	Route::get('solicitud/nueva', [SolicitudesController::class, 'nuevo'])->name('solicitud.new');
	Route::post('solicitud/buscar', [SolicitudesController::class, 'search'])->name('solicitud.buscar');
	Route::post('solicitud/guardar', [SolicitudesController::class, 'submit'])->name('solicitud.submit');
	Route::post('solicitud/modificar', [SolicitudesController::class, 'modificar'])->name('solicitud.modificar');
	Route::post('solicitud/finalizar', [SolicitudesController::class, 'finalizar'])->name('solicitud.finalizar');

	Route::get('solicitud/ver/{solicitud?}', [SolicitudesController::class, 'show'])->name('solicitud.show');
	Route::get('solicitud/edit/{solicitud?}', [SolicitudesController::class, 'show'])->name('solicitud.edit');
	Route::get('solicitud/atender/{solicitud?}', [SolicitudesController::class, 'attend'])->name('solicitud.attend');
	Route::get('solicitudes/productos', [SolicitudesController::class, 'listaProductos'])->name('solicitud.products');
	Route::get('solicitud/pdf/{solicitud?}', [SolicitudesController::class, 'pdf'])->name('solicitud.pdf');
	// Route::get('solicitudes/productos', [SolicitudesController::class, 'nuevo_s'])->name('solicitud.new');


});
