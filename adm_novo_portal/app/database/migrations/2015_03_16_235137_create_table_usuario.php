<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsuario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('usuario'))
		{
			Schema::create('usuario', function($table)
			{
				$table->bigIncrements('id'); 
				$table->string('login');
				$table->string('email');
				$table->string('senha');
				$table->enum('tipo', array('administrador', 'editor'))->default('editor');
				$table->boolean('ativo')->default(true);
				$table->timestamp('criacao');
				$table->timestamp('excluido')->nullable();
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
		if (Schema::hasTable('usuario'))
		{
			Schema::drop('usuario');
		}
	}

}
