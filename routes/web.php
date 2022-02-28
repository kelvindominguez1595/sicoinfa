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
    Route::get('/productoid/{id}', [ProductosController::class, 'productoid']);
    Route::get('/getItemProducts/{id}/{sucursalid}', [ProductosController::class, 'getItemProducts']);
    /** NUEVO INGRESO DE FACTURAS DE PRODUCTOS */
    Route::post('/ingresofactura',[IngresosController::class, 'ingresofactura']);
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
    Route::resource('/usuarios', UsuariosController::class);
    Route::get('/profile', [UsuariosController::class, 'profile']);

});


Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/inventarios', [ProductosController::class, 'inventarios']); // listado para el area de ventas
    Route::get('/list_marcasempleado', [ProductosController::class, 'marcas']);
    Route::get('/list_categoriasempleado', [ProductosController::class, 'categorias']);
    Route::get('/marcasidemp/{id}', [ProductosController::class, 'marcasid']);
    Route::get('/findcategoriesempl/{id}', [ProductosController::class, 'categoriasid']);
});
