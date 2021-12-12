<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSenariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('senarios', function(Blueprint $table)
		{
			$table->foreign('bot_id', 'fk_senarios_bot_id')->references('id')->on('bots')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('senarios', function(Blueprint $table)
		{
			$table->dropForeign('fk_senarios_bot_id');
		});
	}

}
