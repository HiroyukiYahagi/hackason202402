<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('properties', function(Blueprint $table)
		{
			$table->foreign('account_id', 'fk_properties_account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('label_id', 'fk_properties_label_id')->references('id')->on('labels')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('properties', function(Blueprint $table)
		{
			$table->dropForeign('fk_properties_account_id');
			$table->dropForeign('fk_properties_label_id');
		});
	}

}
