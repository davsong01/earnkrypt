<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishingPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->integer('validity');
            $table->float('amount');
            $table->float('return');
            $table->float('daily_returns');
            $table->float('commission')->default(0.5);//Percentage
            $table->text('description');
            $table->text('payment_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publishing_plans');
    }
}
