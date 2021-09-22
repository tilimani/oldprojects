<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::table('rooms',function (Blueprint $table){
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
        });

        Schema::table('coordinates',function (Blueprint $table){
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
        });


        Schema::table('homemates',function (Blueprint $table){
            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::table('houses',function(Blueprint $table){
            $table->integer('manager_id')->unsigned();
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');

            $table->integer('neighborhood_id')->unsigned();
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('cascade');
        });


        Schema::table('image_houses',function(Blueprint $table){
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
        });

        Schema::table('image_rooms',function(Blueprint $table){
            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        Schema::table('qualification_houses',function(Blueprint $table){
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::table('qualification_rooms',function(Blueprint $table){
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::table('qualification_users',function(Blueprint $table){
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::table('qualification_neighborhoods',function(Blueprint $table){
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::table('devices_rooms',function(Blueprint $table){
            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        Schema::table('managers',function(Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('habitants',function(Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        Schema::table('neighborhoods', function (Blueprint $table) {
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });

        Schema::table('bookings',function(Blueprint $table){
            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('status_update',function(Blueprint $table){
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::table('houses_rules',function(Blueprint $table){
            $table->integer('rule_id')->unsigned();
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');

            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('users', function (blueprint $table) {
            $table->dropForeign('users_country_id_foreign');
            $table->dropColumn('country_id');

            $table->dropForeign('users_role_id_foreign');
            $table->dropColumn('role_id');
        });

        Schema::table('rooms',function (blueprint $table){
            $table->dropForeign('rooms_house_id_foreign');
            $table->dropColumn('house_id');
        });

        Schema::table('coordinates',function (blueprint $table){
            $table->dropForeign('coordinates_house_id_foreign');
            $table->dropColumn('house_id');
        });

        Schema::table('homemates',function (blueprint $table){
            $table->dropForeign('homemates_room_id_foreign');
            $table->dropColumn('room_id');

            $table->dropForeign('homemates_country_id_foreign');
            $table->dropColumn('country_id');
        });

        Schema::table('houses',function(blueprint $table){
            $table->dropForeign('houses_manager_id_foreign');
            $table->dropColumn('manager_id');

            $table->dropForeign('houses_neighborhood_id_foreign');
            $table->dropColumn('neighborhood_id');
        });

        Schema::table('image_houses',function(blueprint $table){
            $table->dropForeign('image_houses_house_id_foreign');
            $table->dropColumn('house_id');
        });

        Schema::table('image_rooms',function(blueprint $table){
            $table->dropForeign('image_rooms_room_id_foreign');
            $table->dropColumn('room_id');
        });

        Schema::table('qualification_houses',function(blueprint $table){
            $table->dropForeign('qualification_houses_booking_id_foreign');
            $table->dropColumn('booking_id');
        });

        Schema::table('qualification_rooms',function(blueprint $table){
            $table->dropForeign('qualification_rooms_booking_id_foreign');
            $table->dropColumn('booking_id');
        });

        Schema::table('qualification_users',function(blueprint $table){
            $table->dropForeign('qualification_users_booking_id_foreign');
            $table->dropColumn('booking_id');
        });

        Schema::table('qualification_neighborhoods',function(blueprint $table){
            $table->dropForeign('qualification_neighborhoods_booking_id_foreign');
            $table->dropColumn('booking_id');
        });

        Schema::table('devices_rooms',function(blueprint $table){
            $table->dropForeign('devices_rooms_room_id_foreign');
            $table->dropColumn('room_id');
        });

        Schema::table('managers',function(blueprint $table){
            $table->dropForeign('managers_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('habitants',function(blueprint $table){
            $table->dropForeign('habitants_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('cities', function (blueprint $table) {
            $table->dropForeign('cities_country_id_foreign');
            $table->dropColumn('country_id');
        });

        Schema::table('locations', function (blueprint $table) {
            $table->dropForeign('locations_city_id_foreign');
            $table->dropColumn('city_id');
        });

        Schema::table('neighborhoods', function (blueprint $table) {
            $table->dropForeign('neighborhoods_location_id_foreign');
            $table->dropColumn('location_id');
        });

        Schema::table('bookings',function(blueprint $table){
            $table->dropForeign('bookings_room_id_foreign');
            $table->dropColumn('room_id');

            $table->dropForeign('bookings_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('status_update',function(blueprint $table){
            $table->dropForeign('status_update_booking_id_foreign');
            $table->dropColumn('booking_id');
        });

        Schema::table('houses_rules',function(blueprint $table){
            $table->dropForeign('houses_rules_rule_id_foreign');
            $table->dropColumn('rule_id');

            $table->dropForeign('houses_rules_house_id_foreign');
            $table->dropColumn('house_id');
        });



    }
}
