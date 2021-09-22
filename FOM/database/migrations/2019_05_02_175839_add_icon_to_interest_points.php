<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIconToInterestPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generic_interest_points', function (Blueprint $table) {
            $table->string('icon')->default('noicon.jpg');
        });
        Schema::table('specific_interest_points', function (Blueprint $table) {
            $table->string('icon')->default('noicon.jpg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generic_interest_points', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
        Schema::table('specific_interest_points', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}
