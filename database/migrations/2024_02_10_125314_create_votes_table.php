<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('receipt_id')->nullable();
            $table->dateTime('deadline_at')->nullable();
            $table->unsignedInteger('status')->nullable();
            $table->mediumText('message')->nullable();

            $table->index('user_id', 'fk__votes__user_id_idx');
            $table->index('receipt_id', 'fk__votes__receipt_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
