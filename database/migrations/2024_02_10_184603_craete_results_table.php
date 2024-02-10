<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CraeteResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('usecase_id')->nullable();
            $table->unsignedInteger('affiliation_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('status')->nullable();

            $table->index('usecase_id', 'fk__results__usecase_id_idx');
            $table->index('affiliation_id', 'fk__results__affiliation_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
