<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificInterestPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_interest_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            // $table->string('lat');
            // $table->string('lng');
            // $table->integer('city_id')->unsigned();
            $table->timestamps();
        });
        // Schema::table('specific_interest_points',function(Blueprint $table){
        //     $table->foreign('city_id')->references('id')->on('cities');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('specific_interest_points', function (blueprint $table) {
        //     $table->dropForeign('specific_interest_points_city_id_foreign');
        // });
        Schema::dropIfExists('specific_interest_points');
    }
}
