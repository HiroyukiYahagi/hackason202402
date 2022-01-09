<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBotsTableAddRichmenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->string('rich_menu_id')->nullable();
            $table->string('rich_menu_url')->nullable();
        });

        Schema::table('senarios', function (Blueprint $table) {
            $table->string('rich_menu_id')->nullable();
            $table->string('rich_menu_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bots', function (Blueprint $table) {
            $table->dropColumn('rich_menu_id');
            $table->dropColumn('rich_menu_url');
        });

        Schema::table('senarios', function (Blueprint $table) {
            $table->dropColumn('rich_menu_id');
            $table->dropColumn('rich_menu_url');
        });
    }
}
