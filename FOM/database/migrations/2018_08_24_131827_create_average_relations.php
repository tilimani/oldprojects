<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAverageRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('average_houses', function (Blueprint $table) {
           $table->integer('house_id')->unsigned();
           $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
         });

         Schema::table('average_rooms', function (Blueprint $table) {
           $table->integer('room_id')->unsigned();
           $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
         });

         Schema::table('average_neighborhoods', function (Blueprint $table) {
           $table->integer('neighborhood_id')->unsigned();
           $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('cascade');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::table('average_houses',function(blueprint $table){
           $table->dropForeign('average_houses_house_id_foreign');
           $table->dropColumn('house_id');
       });
       Schema::table('average_rooms',function(blueprint $table){
           $table->dropForeign('average_rooms_room_id_foreign');
           $table->dropColumn('room_id');
       });
       Schema::table('average_neighborhoods',function(blueprint $table){
           $table->dropForeign('average_neighborhoods_neighborhood_id_foreign');
           $table->dropColumn('neighborhood_id');
       });
     }
}
