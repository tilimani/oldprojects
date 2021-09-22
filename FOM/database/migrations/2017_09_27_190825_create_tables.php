<?php

use Illuminate\Support\facades\Schema;
use Illuminate\database\Schema\blueprint;
use Illuminate\database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unsigned();
            $table->string('description', 767)->nullable();
            $table->string('price', 32);
            $table->date('available_from')->nullable();
            $table->timestamps();
        });

        Schema::create('homemates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128)->nullable();
            $table->string('profession', 64)->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->timestamps();
        });

        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('address', 128);
            $table->string('description_house', 767);
            $table->string('description_zone', 767);
            $table->integer('rooms_quantity')->unsigned();
            $table->integer('baths_quantity')->unsigned();
            $table->string('type');
            $table->string('video')->nullable();
            $table->binary('status',5)->nullable();
            $table->timestamps();
        });

       Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('icon_span', 767)->nullable();
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('icon', 64);
            $table->timestamps();
        });

        Schema::create('interest_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->timestamps();
        });

        Schema::create('image_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->binary('priority',10);
            $table->timestamps();
        });

        Schema::create('image_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->binary('priority',10);
            $table->timestamps();
        });

        Schema::create('qualification_houses', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('qualification_rooms', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('qualification_users', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('qualification_neighborhoods', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::create('devices_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bed_type');
            $table->string('bath_type');
            $table->boolean('desk');
            $table->string('windows_type');
            $table->boolean('tv');
            $table->boolean('closet');
            $table->timestamps();
        });

        Schema::create('managers', function (Blueprint $table){
           $table->increments('id');
           $table->boolean('vip');
           $table->timestamps();

        });

        Schema::create('habitants', function (Blueprint $table){
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('roles',function(Blueprint $table ){
            $table->increments('id');
            $table->string('name_role');
            $table->boolean('house');
            $table->timestamps();
        });

        Schema::create('countries',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',128);
            $table->string('icon',64);
            $table->timestamps();
        });

        Schema::create('cities',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',128);
            $table->timestamps();
        });

        Schema::create('locations',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',128);
            $table->timestamps();
        });

        Schema::create('type_interest_points',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',128);
            $table->timestamps();
        });

        Schema::create('neighborhoods',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',128);
            $table->timestamps();
        });

        Schema::create('schools',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',128);
            $table->string('gender')->nullable();
            $table->timestamps();
        });

        Schema::create('bookings',function(Blueprint $table){
            $table->increments('id');
            $table->binary('status',10)->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->timestamps();
        });

        Schema::create('status_update',function(Blueprint $table){
            $table->date('date');
            $table->binary('status',10);
            $table->timestamps();
        });

        Schema::create('houses_rules',function(Blueprint $table){
            $table->increments('id');
            $table->string('description',767);
            $table->timestamps();
        });

        Schema::create('coordinates',function(Blueprint $table){
            $table->string('lat');
            $table->string('lng');
            $table->timestamps();
        });

        Schema::create('device_houses',function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('neighborhood_schools',function(Blueprint $table){
            $table->timestamps();
        });

        Schema::create('favorites',function(Blueprint $table){
            $table->timestamps();
        });
    }

    /**
     * reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropifExists('rooms');
        Schema::dropifExists('homemates');
        Schema::dropifExists('houses');
        Schema::dropifExists('rules');
        Schema::dropifExists('devices');
        Schema::dropifExists('interest_points');
        Schema::dropifExists('image_houses');
        Schema::dropifExists('image_rooms');
        Schema::dropifExists('qualification_houses');
        Schema::dropifExists('qualification_rooms');
        Schema::dropifExists('qualification_users');
        Schema::dropifExists('qualification_neighborhoods');
        Schema::dropifExists('devices_rooms');
        Schema::dropifExists('managers');
        Schema::dropifExists('habitants');
        Schema::dropifExists('roles');
        Schema::dropifExists('countries');
        Schema::dropifExists('cities');
        Schema::dropifExists('locations');
        Schema::dropifExists('type_interest_points');
        Schema::dropifExists('neighborhoods');
        Schema::dropifExists('schools');
        Schema::dropifExists('bookings');
        Schema::dropifExists('status_update');
        Schema::dropifExists('houses_rules');
        Schema::dropifExists('coordinates');
        Schema::dropifExists('device_houses');
        Schema::dropifExists('neighborhood_schools');
        Schema::dropifExists('favorites');

    }
}
