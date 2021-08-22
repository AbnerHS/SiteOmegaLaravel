<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','Leitor\HomeController@index')->name("index");
Route::get('searchField','Leitor\HomeController@searchField')->name("searchField");
Route::any('search','Leitor\HomeController@search')->name("search");
Route::get('leitor/{id}/capitulo/{cap}','Leitor\HomeController@showCapitulo')->name("capitulo");
Route::get('leitor/{id}/avaliar', 'Leitor\HomeController@avaliar')->name('avaliar');
Route::get('leitor/{id}/fav', 'Leitor\HomeController@favoritar')->name('favoritar');
Route::get('perfil','Leitor\PerfilController@index')->name('perfil.index');
Route::get('perfil/{id}/apagar','Leitor\PerfilController@apagarHistorico')->name('perfil.apagar');
Route::resource('leitor', 'Leitor\HomeController')->only([
    'index','show'
]);
Route::get('projetos','Leitor\HomeController@search')->name("projeto");
Route::get('doacao',function(){
    return view('leitor.doacao');
})->name('doacao')->middleware('notifica.capitulo');
Route::any("usuario/search","Painel\UsuarioController@search")->name("usuario.search");
Route::resource("painel/usuarios",'Painel\UsuarioController')
    ->middleware(['auth','check.is.admin']);

Route::resource("painel/generos","Painel\GeneroController")
    ->middleware(['auth','check.is.admin']);
Route::resource("painel/autors","Painel\AutorController")
    ->middleware(['auth','check.is.staff']);
Route::resource("painel/artistas","Painel\ArtistaController")
    ->middleware(['auth','check.is.staff']);
Route::resource("painel/obras", "Painel\ObraController")
    ->middleware(['auth','check.is.staff']);
Route::resource("painel/obras/{id}/capitulos","Painel\CapituloController")
    ->middleware(['auth','check.is.staff']);
Route::resource("painel/scans","Painel\ScanController")
    ->middleware(['auth','check.is.staff']);
Route::resource("painel/doacaos","Painel\DoacaoController")
    ->middleware(['auth','check.is.admin']);
Route::get("painel/",function(){
    return redirect('painel/obras');
})->name("painel");
Auth::routes();
