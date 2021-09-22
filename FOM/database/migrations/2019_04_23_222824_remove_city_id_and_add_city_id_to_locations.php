<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCityIdAndAddCityIdToLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_city_id_foreign');
            $table->dropColumn('city_id');
            $table->unsignedInteger('zone_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->unsignedInteger('city_id')->default(0);
            $table->foreign('city_id')->references('id')->on('cities');
            $table->dropColumn('zone_id');
        });
    }
}
