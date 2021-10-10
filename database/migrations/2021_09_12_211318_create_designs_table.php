<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('design_number')->nullable();
            $table->string('variation')->nullable();
            $table->string('user_id');
            $table->string('payment_type')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(0);//0 - pending; 1: processing; 2 - complete
            $table->string('file')->nullable();
            
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
        Schema::dropIfExists('designs');
    }
}
