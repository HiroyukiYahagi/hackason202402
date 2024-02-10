<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->unsignedInteger('usecase_id')->nullable();
            $table->string('payjp_token')->nullable();
            $table->integer('price')->nullable();
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();

            $table->index('user_id', 'fk__donates__user_id_idx');
            $table->index('shop_id', 'fk__donates__shop_id_idx');
            $table->index('usecase_id', 'fk__donates__usecase_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donates');
    }
}
