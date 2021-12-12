<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bots', function(Blueprint $table)
		{
			$table->foreign('admin_id', 'fk_bots_admin_id')->references('id')->on('admins')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bots', function(Blueprint $table)
		{
			$table->dropForeign('fk_bots_admin_id');
		});
	}

}
