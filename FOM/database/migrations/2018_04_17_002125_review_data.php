<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualification_houses', function (Blueprint $table) {
            //
            $table->tinyInteger('experience');
            $table->tinyInteger('data');
            $table->tinyInteger('devices');
            $table->tinyInteger('wifi');
            $table->tinyInteger('bath');
            $table->tinyInteger('roomies');
            $table->tinyInteger('loudparty');
            $table->tinyInteger('recomend'); 
            $table->string('house_comment');
            $table->string('fom_comment');
        });
        Schema::table('qualification_neighborhoods', function(Blueprint $table) {
            $table->tinyInteger('general');
            $table->tinyInteger('acces');
            $table->tinyInteger('shopping');
        });
        Schema::table('qualification_rooms', function(Blueprint $table) {
            $table->tinyInteger('general');
            $table->tinyInteger('loud');
        });
        Schema::table('qualification_users', function(Blueprint $table) {
            $table->tinyInteger('managerComunication');
            $table->tinyInteger('managerCompromise');
            $table->string('manager_comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qualification_houses', function (Blueprint $table) {
            //
            $table->dropColumn('experience');
            $table->dropColumn('data');
            $table->dropColumn('devices');
            $table->dropColumn('wifi');
            $table->dropColumn('bath');
            $table->dropColumn('roomies');
            $table->dropColumn('loudparty');
            $table->dropColumn('recomend');
            $table->dropColumn('house_comment');
            $table->dropColumn('fom_comment');
        });
        Schema::table('qualification_neighborhoods', function(Blueprint $table) {
            $table->dropColumn('general');
            $table->dropColumn('acces');
            $table->dropColumn('shopping');
        });
        Schema::table('qualification_rooms', function(Blueprint $table) {
            $table->dropColumn('general');
            $table->dropColumn('loud');
        });
        Schema::table('qualification_users', function(Blueprint $table) {
            $table->dropColumn('managerComunication');
            $table->dropColumn('managerCompromise');
            $table->dropColumn('manager_comment');
        });

    }
}