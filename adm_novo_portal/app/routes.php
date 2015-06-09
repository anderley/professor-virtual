<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@show');
// Rotas de notícias
Route::match('get', 'noticias', 'NoticiaController@listar');
Route::match(['get', 'post'], 'listar-noticias', 'NoticiaController@listarNoticias');
Route::get('incluir-noticia', 'NoticiaController@incluir');
Route::post('salvar-noticia', 'NoticiaController@salvar');
Route::get('excluir-noticia/{id}', 'NoticiaController@excluir');
Route::get('editar-noticia/{id}', 'NoticiaController@editar');
Route::get('excluir-noticia-imagem/{id}', 'NoticiaController@excluirImagem');
Route::get('excluir-noticia-edital/{id}', 'NoticiaController@excluirEdital');
// rotas de tags
Route::get('tags', 'TagController@listar');
Route::get('incluir-tag', 'TagController@incluir');
Route::get('editar-tag/{id}', 'TagController@editar');
Route::post('salvar-tag', 'TagController@salvar');
Route::get('excluir-tag/{id}', 'TagController@excluir');
Route::get('ajax/tags.json', function () {
	return Response::make(Tag::select('tag')->whereAtivo(true)->whereNull('excluido')->get());
});
// rota de video
Route::match(['get', 'post'], 'videos', 'VideoController@listar');
Route::get('incluir-video', 'VideoController@incluir');
Route::post('salvar-video', 'VideoController@salvar');
Route::get('excluir-video/{id}', 'VideoController@excluir');
Route::get('editar-video/{id}', 'VideoController@editar');
// rota de apostila
Route::match(['get', 'post'], 'apostilas', 'ApostilaController@listar');
Route::get('incluir-apostila', 'ApostilaController@incluir');
Route::post('salvar-apostila', 'ApostilaController@salvar');
Route::get('excluir-apostila/{id}', 'ApostilaController@excluir');
Route::get('editar-apostila/{id}', 'ApostilaController@editar');
Route::get('pagina-apostila/{page}/{filter?}/{value?}', 'ApostilaController@getPaginaApostilas');
// rota de importação
Route::get('importar-apostilas-opcao', 'ImportarController@apostilasOpcao');