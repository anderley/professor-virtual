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
Route::get('noticia/{titulo}/{id}', 'HomeController@noticia');

Route::get('logout', function () 
{
    Auth::logout();

    return Redirect::to("/");
});

Route::group(array('before' => 'guest'), function ()
{
    Route::get('login', 'LoginController@show');

    Route::get('lembrar-senha', 'LoginController@lembrarSenha');

    Route::post('enviar-senha', 'LoginController@enviarSenha');

    Route::get('reativar-conta/{token}', array(
            'as' => 'reativar-conta',
            'uses' => 'LoginController@reativarConta',
        )
    );

    Route::post('cadastro', 'UsuarioController@cadastro');

    Route::post('novo-cadastro', 'UsuarioController@novoCadastro');

    Route::get('show-cadastro', 'UsuarioController@showCadastro');

    Route::get('ativar-conta/{token}', array(
            'as' => 'ativar-conta',
            'uses' => 'UsuarioController@ativarConta',
        )
    );
});

Route::group(array('before' => 'auth'), function ()
{
    Route::get('minha-conta', array(
            'as' => 'minha-conta',
            'uses' => 'UsuarioController@minhaConta',
        )
    );

    Route::post('atualizar-usuario', array(
            'as' => 'atualizar-cadastro',
            'uses' => 'UsuarioController@atualizarUsuario',
        )
    );

    Route::post('atualizar-endereco', array(
            'as' => 'atualizar-cadastro',
            'uses' => 'UsuarioController@atualizarEndereco',
        )
    );
});

Route::post('autenticar', 'LoginController@autenticar');

Route::post('autenticar-ativacao', 'LoginController@autenticarAtivacao');

