<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLangSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });
        Schema::table('interest_points', function (Blueprint $table) {
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });
        Schema::table('interest_points', function (Blueprint $table) {
            $table->integer('neighborhood_id')->unsigned();
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('cascade');
        });

        Schema::table('interest_points', function (Blueprint $table) {
            $table->integer('type_interest_point_id')->unsigned();
            $table->foreign('type_interest_point_id')->references('id')->on('type_interest_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
        Schema::table('interest_points', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
        Schema::table('interest_points', function (blueprint $table) {
            $table->dropForeign('interest_points_neighborhood_id_foreign');
            $table->dropColumn('neighborhood_id');
        });

        Schema::table('interest_points', function (blueprint $table) {
            $table->dropForeign('interest_points_type_interest_point_id_foreign');
            $table->dropColumn('type_interest_point_id');
        });
    }
}


