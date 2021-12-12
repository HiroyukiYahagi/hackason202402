<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('actions', function(Blueprint $table)
		{
			$table->foreign('rule_id', 'fk_accounts_rule_id')->references('id')->on('rules')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('actions', function(Blueprint $table)
		{
			$table->dropForeign('fk_accounts_rule_id');
		});
	}

}
