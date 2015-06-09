<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordRemindersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('password_reminders'))
		{
			Schema::create('password_reminders', function(Blueprint $table)
			{
				$table->string('email')->index();
				$table->string('token')->index();
				$table->timestamp('created_at');
			});
		}
		if (!Schema::hasTable('tag'))
		{
			Schema::create('tag', function($table)
			{
				$table->bigIncrements('id'); 
				$table->string('tag');
				$table->boolean('ativo')->default(true);
				$table->timestamp('criacao');
				$table->timestamp('excluido')->nullable();
			});
		}
		if (!Schema::hasTable('noticia'))
		{
			Schema::create('noticia', function($table)
			{
				$table->bigIncrements('id');
				$table->string('titulo', 180);
				$table->string('autor', 180)->nullable();
				$table->string('fonte', 180)->nullable();
				$table->date('data_publicacao')->nullable();
				$table->string('link_referencia')->nullable(); 
				$table->string('link_edital')->nullable();
				$table->string('imagem')->nullable();
				$table->text('texto');
				$table->timestamp('criacao');
				$table->timestamp('excluido')->nullable();
			});
		}
		if (!Schema::hasTable('entidade_tag'))
		{
			Schema::create('entidade_tag', function($table)
			{
				$table->bigIncrements('id'); 
				$table->bigInteger('tag_id')->unsigned();
				$table->bigInteger('entidade_id')->unsigned();
				$table->enum('entidade', array('noticia', 'prova', 'questao', 'video'));
				$table->timestamp('criacao');
				$table->timestamp('excluido')->nullable();
				$table->foreign('tag_id')->references('id')->on('tag');
				$table->index('tag_id');
				$table->index(array('entidade_id', 'entidade'));
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
		if (Schema::hasTable('password_reminders'))
		{
			Schema::drop('password_reminders');
		}
		if (Schema::hasTable('entidade_tag'))
		{
			Schema::drop('entidade_tag');
		}
		if (Schema::hasTable('noticia'))
		{
			Schema::drop('noticia');
		}
		if (Schema::hasTable('tag'))
		{
			Schema::drop('tag');
		}
	}

}
