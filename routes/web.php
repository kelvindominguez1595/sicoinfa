<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\IngresosController;
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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('/productos', ProductosController::class);
    Route::resource('/ingresos', IngresosController::class);

    Route::get('/actualizaringresos/{id}/{sucursalid}', [ProductosController::class, 'edit']);
    Route::post('/transferencia', [ProductosController::class, 'transferencia']);

    Route::get('/list_marcas', [ProductosController::class, 'marcas']);
    Route::get('/list_sucursales', [ProductosController::class, 'sucursales']);
    Route::get('/list_categorias', [ProductosController::class, 'categorias']);
    Route::get('/list_proveedores', [ProductosController::class, 'proveedores']);
    Route::get('/list_unidaddenedida', [ProductosController::class, 'unidaddenedida']);
    Route::get('/existenciaProducto/{id}', [ProductosController::class, 'existenciaProducto']);

    Route::get('/marcasid/{id}', [ProductosController::class, 'marcasid']);
    Route::get('/sucursalid/{id}', [ProductosController::class, 'sucursalid']);
    Route::get('/categoriasid/{id}', [ProductosController::class, 'categoriasid']);
    Route::get('/proveedoresid/{id}', [ProductosController::class, 'proveedoresid']);
    Route::get('/unidadmedidaid/{id}', [ProductosController::class, 'unidadmedidaid']);
});


Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/inventarios', [ProductosController::class, 'inventarios']); // listado para el area de ventas
});
