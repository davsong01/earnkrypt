<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('advert_id')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->text('title');
            $table->text('content')->nullable();
            $table->text('status')->default('Draft');
            $table->integer('engagement')->default(0);
            $table->string('posturl')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
