<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('referral_percent');
            $table->double('wallet_rate');
            $table->string('currency')->nullable();
            $table->string('official_mail');
            $table->string('official_wallet');
            $table->integer('payment_delay');
            $table->integer('naira_to_dollar');

            $table->string('advert_email')->nullable()->default('davedeloper@gmail.com');
            $table->string('advert_price')->nullable()->default(10);
            $table->string('advert_payment_link')->nullable();

            $table->string('design_email')->nullable()->default('davedeloper@gmail.com');
            $table->string('logo_price')->nullable();
            $table->string('logo_payment_link')->nullable();
            $table->string('flier_price')->nullable();
            $table->string('flier_payment_link')->nullable();
            $table->string('graphics_video_price')->nullable();
            $table->string('graphics_video_payment_link')->nullable();
            
            $table->double('advert_referral_percent');
            $table->idouble('design_referral_percent');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
