<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->timestamps();
			$table->softDeletes();
			$table->text('body', 16777215)->nullable();
			$table->integer('account_id')->nullable()->index('fk_messages_account_id_idx');
			$table->integer('send_by')->nullable();
			$table->integer('action_id')->nullable()->index('fk_messages_action_id_idx');
			$table->string('message_token', 256)->nullable();
			$table->string('reply_token', 256)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}
