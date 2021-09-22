<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TermsAndConditionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms_and_conditions_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('version', 767)->nullable();
            $table->timestamps();
        });

        Schema::create('user_terms_and_conditions', function (Blueprint $table) {
            $table->string('hash', 767)->nullable();
            $table->string('differentiator', 767)->nullable();
            $table->date('date_acceptation')->nullable();
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
        Schema::dropifExists('terms_and_conditions_versions');
        Schema::dropifExists('user_terms_and_conditions');
    }
}
