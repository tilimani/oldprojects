<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_uses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('paid')->default(false);
            $table->string('payment_method')->default('unpaid');
        });
        Schema::table('referral_uses',function (Blueprint $table) {
            $table->integer('vico_referral_id')->unsigned();
            $table->foreign('vico_referral_id')->references('id')->on('vico_referrals')->onDelete('cascade');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_uses', function (blueprint $table) {
            $table->dropForeign('referral_uses_vico_referral_id_foreign');
            $table->dropColumn('vico_referral_id');
            
            $table->dropForeign('referral_uses_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('referral_uses');
    }
}
