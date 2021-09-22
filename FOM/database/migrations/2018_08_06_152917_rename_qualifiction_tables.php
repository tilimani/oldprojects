<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameQualifictionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('qualification_houses', function(Blueprint $table){
          $table->increments('id')->first();
          $table->renameColumn('booking_id', 'bookings_id');
          $table->renameColumn('recomend', 'recommend');
        });

        Schema::table('qualification_neighborhoods', function(Blueprint $table){
          $table->increments('id')->first();
          $table->renameColumn('booking_id', 'bookings_id');
          $table->renameColumn('acces', 'access');
        });

        Schema::table('qualification_rooms', function(Blueprint $table){
          $table->increments('id')->first();
          $table->renameColumn('booking_id', 'bookings_id');
          $table->tinyInteger('data');
          $table->tinyInteger('wifi');
        });

        Schema::table('qualification_users', function(Blueprint $table){
          $table->increments('id')->first();
          $table->renameColumn('booking_id', 'bookings_id');
          $table->renameColumn('managerComunication', 'manager_comunication');
          $table->renameColumn('managerCompromise', 'manager_compromise');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('qualification_houses', function(Blueprint $table){
          $table->dropColumn('id');
          $table->renameColumn('bookings_id', 'booking_id');
          $table->renameColumn('recommend', 'recomend');
        });
        Schema::table('qualification_neighborhoods', function(Blueprint $table){
          $table->dropColumn('id');
          $table->renameColumn('bookings_id', 'booking_id');
          $table->renameColumn('access', 'acces');
        });

        Schema::table('qualification_rooms', function(Blueprint $table){
          $table->dropColumn('id');
          $table->renameColumn('bookings_id', 'booking_id');
          $table->dropColumn('data');
          $table->dropColumn('wifi');
        });

        Schema::table('qualification_users', function(Blueprint $table){
          $table->dropColumn('id');
          $table->renameColumn('bookings_id', 'booking_id');
          $table->renameColumn('manager_comunication', 'managerComunication');
          $table->renameColumn('manager_compromise', 'managerCompromise');
        });
    }
}
