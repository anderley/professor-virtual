<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVideo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('video'))
		{
			Schema::create('video', function($table)
			{
				$table->bigIncrements('id'); 
				$table->string('titulo');
				$table->text('embedded');
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
		if (Schema::hasTable('video'))
		{
			Schema::drop('video');
		}
	}

}
