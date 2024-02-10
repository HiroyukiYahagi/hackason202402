<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsecasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usecases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();

            $table->unsignedInteger('thema_id')->nullable();
            $table->unsignedInteger('donate_id')->nullable();

            $table->integer('price')->nullable();

            $table->index('donate_id', 'fk__usecases__donate_id_idx');
            $table->index('thema_id', 'fk__usecases__thema_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usecases');
    }
}
