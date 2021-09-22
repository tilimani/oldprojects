<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationsTermsAndConditionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_terms_and_conditions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('tac_id')->unsigned();
            $table->foreign('tac_id')->references('id')->on('terms_and_conditions_versions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_terms_and_conditions', function (blueprint $table) {
            $table->dropForeign('user_terms_and_conditions_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('user_terms_and_conditions_tac_id_foreign');
            $table->dropColumn('tac_id');
        });
    }
}
