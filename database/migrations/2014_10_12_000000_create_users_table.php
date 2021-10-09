<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('wallet_address')->unique()->nullable();
            $table->string('eth_wallet_address')->unique()->nullable();
            $table->string('ltc_wallet_address')->unique()->nullable();
            $table->string('bnb_wallet_address')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('my_referral_code')->nullable();
            $table->string('my_upline')->nullable();
            $table->string('publishing_plans_id')->nullable();
            $table->datetime('plan_expiry')->nullable();
            $table->float('wallet_balance')->nullable()->default(0);
            $table->float('referral_wallet_balance')->nullable()->default(0);
            $table->float('medals_wallet_balance')->nullable()->default(0);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->integer('user_types')->default(1);//Super Admin=3, Admin=2, User=1
            $table->timestamp('email_verified_at')->nullable();
            $table->string('provider', 20)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
