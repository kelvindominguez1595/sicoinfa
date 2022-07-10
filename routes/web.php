<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\IngresosController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\MedidasController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\SucursalesController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DeudasController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\ProductosAJAXController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;

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

Route::get('/', function () {
    if(Auth::check()){
        return view('home');
    } else {
        return view('auth.login');
    }
});

Auth::routes();
Route::post('/customLogin', [UsuariosController::class, 'customLogin'])->name('customLogin');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/roles', RolesController::class);
Route::resource('/permisos', PermissionsController::class);
Route::get('/premissionasig/{id}', [RolesController::class, 'premissionasig'])->name('premissionasig');
Route::get('/asigpermissions', [RolesController::class, 'asignpermission'])->name('asigpermissions');

Route::group(['middleware' => ['auth', 'admin']], function () {
    /** TODO ESTO ES PARA HACER UN INGRESO Y FILTRO DE PRODUCTOS */
    Route::resource('/productos', ProductosController::class);

    Route::resource('/ingresos', IngresosController::class);

    Route::get('/actualizaringresos/{id}/{sucursalid}', [ProductosController::class, 'edit']);
    Route::post('/transferencia', [ProductosController::class, 'transferencia']);
    Route::post('/ajusteproducto', [ProductosController::class, 'ajusteproducto']);

    Route::get('/list_marcas', [ProductosController::class, 'marcas']);
    Route::get('/list_categorias', [ProductosController::class, 'categorias']);
    Route::get('/list_sucursales', [ProductosController::class, 'sucursales']);
    Route::get('/list_proveedores', [ProductosController::class, 'proveedores']);
    Route::get('/list_unidaddenedida', [ProductosController::class, 'unidaddenedida']);
    Route::get('/existenciaProducto/{id}', [ProductosController::class, 'existenciaProducto']);

    Route::get('/marcasid/{id}', [ProductosController::class, 'marcasid']);
    Route::get('/sucursalid/{id}', [ProductosController::class, 'sucursalid']);
    Route::get('/categoriasid/{id}', [ProductosController::class, 'categoriasid']);
    Route::get('/proveedoresid/{id}', [ProductosController::class, 'proveedoresid']);
    Route::get('/unidadmedidaid/{id}', [ProductosController::class, 'unidadmedidaid']);
    Route::get('/historialcompras', [ProductosController::class, 'historialcompras']);
    Route::get('/listarproductos', [ProductosController::class, 'listarproductos']);
    Route::get('/buscarProductosIngreso', [ProductosController::class, 'buscarProductosIngreso']);
    Route::get('/productoid/{id}', [ProductosController::class, 'productoid']);
    Route::get('/getItemProducts/{id}/{sucursalid}', [ProductosController::class, 'getItemProducts']);
    /** NUEVO INGRESO DE FACTURAS DE PRODUCTOS */
    Route::get('/ingresofactura',[IngresosController::class, 'ingresofactura']);
    Route::get('/modificarPrecioVenta/{factura}',[IngresosController::class, 'modificarPrecioVenta']);
    Route::post('/modprecioventa',[IngresosController::class, 'modprecioventa']);
    Route::get('/precioRealdelProducto/{producto}/{sucursal}', [IngresosController::class, 'precioRealdelProducto']);

    /** MARCAS */
    Route::resource('/marcas', MarcasController::class);
    /** CATEGORIAS */
    Route::resource('/categorias', CategoriasController::class);
    /** MEDIDAS */
    Route::resource('/medidas', MedidasController::class);
    /** PROVEEDORES */
    Route::resource('/proveedores', ProveedoresController::class);
    Route::get('/desactivarproveedores/{id}', [ProveedoresController::class, 'desactivarproveedores']);
    /** CLIENTES */
    Route::resource('/clientes', ClientesController::class);
    Route::get('/clientesList', [ClientesController::class, 'clientesList']);
    Route::get('/contribuyentesList', [ClientesController::class, 'contribuyentesList']);

    /** EMPLEADOS */
    Route::resource('/empleados', EmpleadosController::class);
    Route::get('/listdateemp', [EmpleadosController::class, 'listdateemp']);
    /** USUARIOS */
    Route::resource('/usuarios', UsuariosController::class);
    Route::get('/profile', [UsuariosController::class, 'profile']);
    Route::get('/listuserdata', [UsuariosController::class, 'listuserdata']);
    /** SUCRUSALES */
    Route::resource('/sucursales', SucursalesController::class);
    Route::get('/listsubcursal', [SucursalesController::class, 'listsubcursal']);
    /** REPORTES */
    Route::get('/Reportes', [ReporteController::class, 'reportes']);

    Route::get('/promedio', [ReporteController::class, 'promedio']);
    Route::get('/rendimiento', [ReporteController::class, 'rendimiento']);
    Route::get('/porcentajereporte', [ReporteController::class, 'porcentajereporte']);

    Route::get('/detView', [ReporteController::class, 'detView']);
    Route::get('/reporteDET', [ReporteController::class, 'reporteDET']);

    /** RUTAS PARA DEUDAS */
    Route::get('/deudas', [DeudasController::class, 'index']);
    Route::post('/nuevadeuda', [DeudasController::class, 'nuevadeuda']);
    Route::post('/notacredito', [DeudasController::class, 'notacredito']);
    Route::post('/pagos', [DeudasController::class, 'pagos']);
    Route::post('/abonos', [DeudasController::class, 'abonos']);
    Route::get('/loaddatadeuda', [DeudasController::class, 'loaddatadeuda']);
    Route::get('/showdeudas', [DeudasController::class, 'showdeudas']);

    Route::get('/addModdate/{date}',[DeudasController::class, 'addModdate']);
    Route::get('/dateNow',[DeudasController::class, 'dateNow']);
    Route::get('/searchfactura',[DeudasController::class, 'searchfactura']);
    Route::get('/deudashow/{id}',[DeudasController::class, 'deudashow']);
    Route::get('/findnotas/{id}',[DeudasController::class, 'findnotas']);
    Route::get('/findpagos/{id}',[DeudasController::class, 'findpagos']);
    Route::get('/findabonos/{id}',[DeudasController::class, 'findabonos']);
    Route::get('/finddeudas',[DeudasController::class, 'finddeudas']);
    Route::delete('/deletedeudasall/{id}',[DeudasController::class, 'deletedeudasall']);
    Route::delete('/destroypagos/{id}',[DeudasController::class, 'destroypagos']);
    Route::delete('/destroyabonos/{id}',[DeudasController::class, 'destroyabonos']);
    Route::delete('/destroycredito/{id}',[DeudasController::class, 'destroycredito']);
    Route::delete('/findpagoopt/{id}',[DeudasController::class, 'findpagoopt']);
    Route::get('/updatedDeudas',[DeudasController::class, 'updatedDeudas']);
    // para ver las notificaciones
    // para reportes de deudas
    Route::get('/deudasreportes', [ReporteController::class, 'deudasreportes']);
    Route::get('/selectereportedeudas', [ReporteController::class, 'selectereportedeudas']);
    /** PRUEBA DE LA NUEVA BUSQUEDA */
    Route::get('listadodeproductos', [ProductosAJAXController::class, 'index']);
    Route::get('loadproducts', [ProductosAJAXController::class, 'loadproducts']);
    Route::get('loadlastproduct', [ProductosAJAXController::class, 'loadlastproduct']);

});

Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/inventarios', [ProductosController::class, 'index']);

    Route::get('/list_marcasempleado', [ProductosController::class, 'marcas']);
    Route::get('/list_categoriasempleado', [ProductosController::class, 'categorias']);
    Route::get('/marcasidemp/{id}', [ProductosController::class, 'marcasid']);
    Route::get('/findcategoriesempl/{id}', [ProductosController::class, 'categoriasid']);
});
/** rutas tanto para administradore y otros usuarios **/
Route::group(['middleware' => ['auth']], function () {
    Route::get('/bandejaNotificaciones',[NotificacionesController::class, 'notify']);
    Route::get('/detalleProductoNotificaction/{id}',[NotificacionesController::class, 'detalleProductoNotificaction']);
});
