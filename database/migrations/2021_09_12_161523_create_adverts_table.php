<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('advert_number')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('user_id');
            $table->string('amount_paid')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('link')->nullable();
            $table->text('comment')->nullable();
            $table->string('status')->default(0);//0 - not approved; 1 - approved

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
        Schema::dropIfExists('adverts');
    }
}
