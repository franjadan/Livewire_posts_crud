<?php

use Illuminate\Support\Facades\Route;

//Importar componentes
Use App\Http\Livewire\ShowPosts;

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
    redirect()->route('dashboard');
});

/*
Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', function(){
        return view('dashboard');
    });
});
*/

//Llamar al controlador de livewire directamente desde
/*
Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', ShowPosts::class);
});*/

//Route::get('prueba/{name}', ShowPosts::class);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', ShowPosts::class)->name('dashboard');
});


Auth::routes();

