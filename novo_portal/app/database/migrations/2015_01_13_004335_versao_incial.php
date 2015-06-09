<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VersaoIncial extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('usuario'))
		{
			Schema::create('usuario', function($table)
			{
				$table->bigIncrements('id'); 
				$table->string('senha', 100); 
				$table->string('senha_tmp', 100)->nullable(); 
				$table->string('token', 100)->nullable(); 
				$table->string('email', 100);
				$table->string('nome', 100);
				$table->string('login', 50);
				$table->dateTime('criado'); 
				$table->dateTime('modificado')->nullable(); 
				$table->dateTime('excluido')->nullable(); 
				$table->boolean('ativo');
				$table->char('sexo')->nullable();
				$table->date('data_nascimento')->nullable();
				$table->string('telefone', 20)->nullable();
				$table->string('celular', 20)->nullable();
			});
		}

		if(!Schema::hasTable('endereco') && Schema::hasTable('usuario'))
		{
			Schema::create('endereco', function($table)
			{
				$table->bigIncrements('id'); 
				$table->string('logradouro', 180); 
				$table->string('numero', 10); 
				$table->string('complemento', 30)->nullable(); 
				$table->string('bairro', 180);
				$table->string('cidade', 180);
				$table->string('uf', 2);
				$table->string('cep', 10);
				$table->integer('codigo_ibge');
				$table->dateTime('excluido')->nullable(); 
				$table->boolean('principal')->default(true);
				$table->bigInteger('usuario_id')->unsigned()->nullable();
				$table->foreign('usuario_id')->references('id')->on('usuario');
				$table->index('usuario_id');
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if(Schema::hasTable('endereco'))
		{
			Schema::drop('endereco');
		}
		if(Schema::hasTable('usuario'))
		{
			Schema::drop('usuario');
		}
	}

}
