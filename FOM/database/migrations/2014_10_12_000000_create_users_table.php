<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email',100)->unique()->nullable();
            $table->string('password');
            $table->string('phone',20)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('image_id')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('description', 767)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}