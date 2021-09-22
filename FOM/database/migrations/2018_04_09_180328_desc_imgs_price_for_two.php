<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DescImgsPriceForTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image_rooms', function (Blueprint $table) {
            $table->string('description', 767);
        });
        Schema::table('image_houses', function (Blueprint $table) {
           $table->string('description', 767); 
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('price_for_two', 32)->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('image_rooms', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('image_houses', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('price_for_two');
        });
    }
}
