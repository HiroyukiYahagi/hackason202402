<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('coco_db')->create('meta_ad_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('partner_name', 256)->nullable()->index('fk_meta_ad_results_partner_name_idx');
            $table->string('media_name', 256)->nullable()->index('fk_meta_ad_results_media_name_idx');
            $table->string('campaign_name', 256)->nullable();
            $table->string('adset_name', 256)->nullable();
            $table->string('ad_name', 256)->nullable();

            $table->string('placement', 256)->nullable();

            $table->string('campaign_id', 256)->nullable()->index('fk_meta_ad_results_campaign_id_idx');
            $table->string('adset_id', 256)->nullable()->index('fk_meta_ad_results_adset_id_idx');
            $table->string('ad_id', 256)->nullable()->index('fk_meta_ad_results_ad_id_idx');

            $table->dateTime('target_at')->nullable()->index('fk_meta_ad_results_target_at_idx');


            $table->mediumText('full_link')->nullable();
            $table->mediumText('dump')->nullable();


            $table->mediumText('ad_text')->nullable();
            $table->mediumText('ad_image')->nullable();

            $table->double('cost')->default(0);
            $table->double('impression')->default(0);
            $table->double('frequency')->default(0);
            $table->double('click')->default(0);
            $table->double('conversion')->default(0);


            $table->mediumText('link_url')->nullable();
            $table->string('utm_source', 256)->nullable();
            $table->string('utm_medium', 256)->nullable();
            $table->string('utm_campaign', 256)->nullable();
            $table->string('utm_content', 256)->nullable();
            $table->string('utm_term', 256)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('coco_db')->dropIfExists('meta_ad_results');
    }
}
