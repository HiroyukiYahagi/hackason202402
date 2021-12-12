<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rules', function(Blueprint $table)
		{
			$table->foreign('senario_id', 'fk_rules_senario_id')->references('id')->on('senarios')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rules', function(Blueprint $table)
		{
			$table->dropForeign('fk_rules_senario_id');
		});
	}

}
