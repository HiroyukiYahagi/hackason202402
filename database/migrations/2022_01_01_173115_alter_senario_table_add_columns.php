<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSenarioTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('senarios', function (Blueprint $table) {
            $table->integer('priority')->default(100);
            $table->integer('is_valid')->default(0);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('senario_id')->nullable()->index('fk_accounts_senario_id_idx');
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
            $table->dropColumn('priority');
            $table->dropColumn('is_valid');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('senario_id');
        });
    }
}
