<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VicoReferrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vico_referrals', function(Blueprint $table) {
            $table->increments('id');
            $table->string('code', 15)->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->string('type')->nullable();
            $table->integer('amount_usd')->nullable();
            $table->integer('payout')->nullable();
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
        Schema::dropIfExists('vico_referrals');
    }
}
