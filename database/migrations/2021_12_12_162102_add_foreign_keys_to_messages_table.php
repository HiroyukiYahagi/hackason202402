<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function(Blueprint $table)
		{
			$table->foreign('account_id', 'fk_messages_account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('action_id', 'fk_messages_action_id')->references('id')->on('actions')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('messages', function(Blueprint $table)
		{
			$table->dropForeign('fk_messages_account_id');
			$table->dropForeign('fk_messages_action_id');
		});
	}

}
