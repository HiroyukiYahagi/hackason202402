<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBotsTableAddParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('senarios', function (Blueprint $table) {
            $table->string('query_label')->nullable();
        });
        Schema::table('bots', function (Blueprint $table) {
            $table->string('query_label')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('senarios', function (Blueprint $table) {
            $table->dropColumn('query_label');
        });
        Schema::table('bots', function (Blueprint $table) {
            $table->dropColumn('query_label');
        });
    }
}
