<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAverageHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('average_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->float('global');
            $table->float('experience');
            $table->float('data');
            $table->float('devices');
            $table->float('wifi');
            $table->float('bath');
            $table->float('roomies');
            $table->float('loudparty');
            $table->float('manager_compromise');
            $table->float('manager_comunication');
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
        Schema::dropIfExists('average_houses');
    }
}
