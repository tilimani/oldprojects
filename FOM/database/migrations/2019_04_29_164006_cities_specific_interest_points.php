<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CitiesSpecificInterestPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities_specific_interest_points', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('specific_interest_point_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities_specific_interest_points');
    }
}
