<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableApostila extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('apostila'))
		{
			Schema::create('apostila', function($table)
			{
				$table->bigIncrements('id');
				$table->string('titulo', 180);
				$table->string('cargo', 180)->nullable();
				$table->string('imagem')->nullable();
				$table->decimal('valor_impresso', 5, 2);
				$table->decimal('valor_digital', 5, 2)->nullable(); 
				$table->string('link_parceiro')->nullable();
				$table->boolean('ativo')->default(true);
				$table->timestamp('criacao');
				$table->timestamp('excluido')->nullable();
			});
		}
		if (Schema::hasTable('entidade_tag'))
		{
			Schema::table('entidade_tag', function($table)
			{
				$table->dropColumn('entidade');
			});
			Schema::table('entidade_tag', function($table)
			{
				$table->enum('entidade', array('noticia', 'prova', 'questao', 'video', 'apostila'));
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
		if (Schema::hasTable('apostila'))
		{
			Schema::drop('apostila');
		}
		if (Schema::hasTable('entidade_tag'))
		{
			Schema::table('entidade_tag', function($table)
			{
				$table->dropColumn('entidade');
			});
			Schema::table('entidade_tag', function($table)
			{
				$table->enum('entidade', array('noticia', 'prova', 'questao', 'video'));
			});
		}
	}

}
